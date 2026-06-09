<?php

namespace App\Models\Port;

use App\Scopes\TrashScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class Cert_Security extends Model
{
    use  HasFactory;


    protected $table = SECCERT;
    protected $primaryKey = 'comp_cert_id';
    protected $fillable = [
        'port_fk_id',
        'cert_name',
        'cert_file_name',
        'cert_path',
        'cert_ext',
        'cert_size',
        'cert_start_date',
        'cert_end_date',
        'cert_status',
        'status',
        'trash',
        'created_by',
        'updated_by',
    ];
    protected $attributes = [
        'status' => 1,
        'trash' => 'NO',
    ];

    public function list()
    {
        $request = request();
        $search = '';

        $query = $this->select('incident_master_category.*');



        $data_count = $query->count();
        $total_records = $data_count;

        $query->orderBy('id', 'DESC');


        if ($request->length != -1) {
            $query->offset($request->start)->limit($request->length);
        }

        $data = $query->get();

        $datas = [
            'data' => $data,
            'total_records' => $total_records
        ];

        return $datas;
    }

    public function store($id)
    {
        $request = request();

        $cert_name       = $request->cert_name;
        $cert_start_date = $request->cert_start_date;
        $cert_end_date   = $request->cert_end_date;
        $files           = $request->file('other_competency_certi');

        $destinationPath = storage_path('app/public/contractors');

        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0777, true);
        }

        if (is_array($cert_name) && count($cert_name) > 0) {

            foreach ($cert_name as $key => $value) {

                // STORE ONLY IF DATA EXISTS
                if (
                    !empty($cert_name[$key]) ||
                    !empty($cert_start_date[$key]) ||
                    !empty($cert_end_date[$key]) ||
                    !empty($files[$key])
                ) {

                    $fileName = null;
                    $fileExt  = null;
                    $fileSize = null;
                    $filePath = null;

                    // FILE STORE
                    if (isset($files[$key]) && $files[$key] != null) {

                        $file = $files[$key];

                        $fileName = Str::uuid()->toString() . '.' . $file->getClientOriginalExtension();

                        $fileExt  = $file->getClientOriginalExtension();

                        $fileSize = $file->getSize();

                        $file->move($destinationPath, $fileName);

                        $filePath = 'storage/contractors/' . $fileName;
                    }

                    $insert_array = array(

                        'port_fk_id'             => $id,
                        'cert_name'                 => $cert_name[$key] ?? null,
                        'cert_start_date'           => DBdateformat($cert_start_date[$key]) ?? null,
                        'cert_end_date'             => DBdateformat($cert_end_date[$key]) ?? null,

                        'cert_path'   => $filePath,
                        'cert_file_name'                 => $fileName,
                        'cert_ext'                  => $fileExt,
                        'cert_size'                 => $fileSize,

                        'created_by'                => Auth::id()

                    );
                    $this->create($insert_array);
                }
            }
        }

        return true;
    }

    public function updates($id)
    {
        $request = request();
        $cert_ids        = $request->cert_id ?? [];
        $cert_names      = $request->cert_name ?? [];
        $cert_start_dates = $request->cert_start_date ?? [];
        $cert_end_dates  = $request->cert_end_date ?? [];
        $files           = $request->file('other_competency_certi') ?? [];
        $destinationPath = storage_path('app/public/contractors');

        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0777, true);
        }

        foreach ($cert_names as $key => $certName) {

            // Skip completely empty rows
            if (
                empty($certName) &&
                empty($cert_start_dates[$key]) &&
                empty($cert_end_dates[$key]) &&
                empty($files[$key])
            ) {
                continue;
            }

            $certId    = $cert_ids[$key] ?? null;
            $isExisting = !empty($certId); // has encrypted ID = existing record

            $fileName = null;
            $fileExt  = null;
            $fileSize = null;
            $filePath = null;

            // Handle new file upload if provided for this index
            if (isset($files[$key]) && $files[$key] instanceof \Illuminate\Http\UploadedFile) {

                $file     = $files[$key];
                $fileName = Str::uuid()->toString() . '.' . $file->getClientOriginalExtension();
                $fileExt  = $file->getClientOriginalExtension();
                $fileSize = $file->getSize();
                $file->move($destinationPath, $fileName);
                $filePath = 'storage/contractors/' . $fileName;
            }

            if ($isExisting) {

                $updateData = [
                    'cert_name'       => $certName ?? null,
                    'cert_start_date' => DBdateformat($cert_start_dates[$key]) ?? null,
                    'cert_end_date'   => DBdateformat($cert_end_dates[$key]) ?? null,
                    'updated_by'      => Auth::id(),
                ];

                // Only update file fields if a new file was uploaded
                if ($filePath) {
                    $updateData['cert_path']      = $filePath;
                    $updateData['cert_file_name'] = $fileName;
                    $updateData['cert_ext']       = $fileExt;
                    $updateData['cert_size']      = $fileSize;
                }
                $this->where('comp_cert_id', $certId)->update($updateData);
            } else {

                // INSERT new record
                $insertData = [
                    'port_fk_id'      => $id,
                    'cert_name'       => $certName ?? null,
                    'cert_start_date' => DBdateformat($cert_start_dates[$key]) ?? null,
                    'cert_end_date'   => DBdateformat($cert_end_dates[$key]) ?? null,
                    'cert_path'       => $filePath,
                    'cert_file_name'  => $fileName,
                    'cert_ext'        => $fileExt,
                    'cert_size'       => $fileSize,
                    'created_by'      => Auth::id(),
                ];

                $this->create($insertData);
            }
        }
    }

    public function selectcerticatedata($id)
    {

        $data = $this->select('*')
            ->where('port_fk_id', $id)
            ->get();

        return $data;
    }
    protected static function booted()
    {
        static::addGlobalScope(new TrashScope(SECCERT));
    }
}
