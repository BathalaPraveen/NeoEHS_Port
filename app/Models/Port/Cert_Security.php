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
    protected $primaryKey = 'id';
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

        $update_array = array(
            'category_name' => $request->category_name,
            'updated_by' => Auth::id()
        );

        return $this->where('id', $id)->update($update_array);
    }

    public function statuschange($id)
    {
        $request = request();

        $type = $request->types;
        if ($type == 1) {
            $update_data = array(
                'status' => 0,
            );
        } else {
            $update_data = array(
                'status' => 1,
            );
        }

        return $this->where('id', $id)->update($update_data);
    }

    public function deleterecord($id)
    {

        $update_data = array(
            'status' => 0,
            'trash' => 'YES',
        );

        return $this->where('id', $id)->update($update_data);
    }

    public function exportdata()
    {
        $request = request();
        $search = '';

        $query = $this->select('incident_master_category.*');



        $query = $query->orderBy('id', 'Desc');
        return  $query->get();
    }

    public function selectcerticatedata($id)
    {

        $data = $this->select('*')
            ->where('port_fk_id', $id)
            ->get();

        return $data;
    }

    public function selectOneWhere($where)
    {

        $data = $this->select('*')
            ->where($where)
            ->first();

        return $data;
    }

    public function ajaxList()
    {

        $query = $this->select('id', 'category_name');

        $datas = $query->get();

        $list = [];
        foreach ($datas as $data) {
            $listvalue = [];
            $listvalue['id'] = encryptId($data->id);
            $listvalue['name'] = $data->category_name;

            $list[] = $listvalue;
        }
        return $list;
    }

    public function getWhere()
    {

        $query = $this->select('id', 'category_name', 'input_type', 'required', 'other_params');

        $datas = $query->get();


        return $datas;
    }


    protected static function booted()
    {
        static::addGlobalScope(new TrashScope(SECCERT));
    }
}
