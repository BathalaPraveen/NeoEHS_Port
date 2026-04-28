<?php

namespace App\Models\Chemical;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

use File;
use Str;
use App\Scopes\TrashScope;

class ChemicalListDetails extends Model
{
    use  HasFactory;


    protected $table = 'chemical_chemical_list_details';
    protected $primaryKey = 'id';

    protected $fillable = [
        'chemical_list_id',
        'name_of_chemical',
        'physical_form_of_chemical',
        'phy_others',
        'usage_of_chemical_quantity',
        'cas_no',
        'comply_with_classification_sds',
        'name_of_hazardous_ingredient',
        'compostion_hazardous_ingredient',
        'uocunit',
        'supplier_details',
        'prep_date',
        'revision_date',
        'sds_file_path',
        'sds_org_name',
        'status',
        'trash',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'

    ];

    protected $attributes = [
        'status' => 1,
        'trash' => 'NO',
    ];


    public function store($listId)
    {

        $request = request();

        $rowcount = count($request->chemicalname);

        for ($i = 1; $i <= $rowcount; $i++) {


            $ImagefileList = $request->file('sdsattachment');

            $Imagefile = $ImagefileList[$i];

            $uploadpath = 'public/uploads/chemical/list/' . $listId;

            $folderPath = public_path('uploads/chemical/list/' . $listId);

            if (!File::exists($folderPath)) {

                File::makeDirectory($folderPath, 0755, true);
            }

            $filenewname = time() . Str::random('20') . '.' . $Imagefile->getClientOriginalExtension();

            $Imagefile->move($uploadpath, $filenewname);

            $path = $uploadpath . "/" . $filenewname;
            $fileName = $Imagefile->getClientOriginalName();

            $insert_array = array(
                'chemical_list_id' => $listId,
                'name_of_chemical' => decryptId($request->chemicalname[$i]),
                'name_of_hazardous_ingredient' => $request->name_of_hazardous_ingredient[$i],
                'cas_no' => $request->casno[$i],
                'compostion_hazardous_ingredient' => $request->compostion_hazardous_ingredient[$i],
                'physical_form_of_chemical' => decryptId($request->phyformofchemical[$i]),
                'phy_others' => $request->phy_others[$i],
                'usage_of_chemical_quantity' => $request->uocmonth[$i] . "_" . $request->uocmonthyear[$i],
                'uocunit' => decryptId($request->uocunit[$i]),
                'supplier_details' => decryptId($request->supplier[$i]),
                'comply_with_classification_sds' => $request->nameofai_sds[$i],
                'prep_date' => DBdateformat($request->prep_date[$i]),
                'revision_date' => DBdateformat($request->revision_date[$i]),

                'sds_file_path' => $path,
                'sds_org_name' => $fileName,
                'created_by' => Auth::id()
            );

            $this->create($insert_array);
        }

        return true;
    }

    public function updates($id)
    {
        $request = request();
        // dd($request->all());
        $chemicalListId = $id;
        // dd($request->chemicalname);
        $this->where('chemical_list_id', $chemicalListId)->update([
            'status' => 0,
            'trash' => 'YES',
        ]);

        $chemicalNames = $request->chemicalname ?? [];
        // dd($chemicalNames);
        $rowcount = count($chemicalNames);
        // dd($rowcount);

        for ($i = 1; $i <= $rowcount; $i++) {

            $editIdArr = $request->editid ?? [];
            $editIdEncrypted = $editIdArr[$i] ?? null;
            $isNew = empty($editIdEncrypted);

            $sdsFileList = $request->file('sdsattachment') ?? [];
            $sdsFile = $sdsFileList[$i] ?? null;

            $sdsFilePath = null;
            $sdsOrgName = null;

            if ($sdsFile && $sdsFile->isValid()) {
                $uploadPath = 'uploads/chemical/list/' . $chemicalListId;
                $folderPath = public_path($uploadPath);

                if (!File::exists($folderPath)) {
                    File::makeDirectory($folderPath, 0755, true);
                }

                $newFileName = time() . Str::random(20) . '.' . $sdsFile->getClientOriginalExtension();
                $sdsFile->move($folderPath, $newFileName);

                $sdsFilePath = 'public/' . $uploadPath . '/' . $newFileName;
                $sdsOrgName = $sdsFile->getClientOriginalName();
            }
            // dd($request->all());
            // Now prepare the data safely
            $data = [
                'chemical_list_id' => $chemicalListId,
                'name_of_chemical' => decryptId($request->chemicalname[$i] ?? ''),
                'name_of_hazardous_ingredient' => $request->name_of_hazardous_ingredient[$i] ?? null,
                'cas_no' => $request->casno[$i] ?? null,
                'compostion_hazardous_ingredient' => $request->compostion_hazardous_ingredient[$i] ?? null,
                'physical_form_of_chemical' => array_to_string(arrayDecrypt($request->phyformofchemical[$i] ?? [])),
                'phy_others' => $request->phy_others[$i] ?? null,
                'usage_of_chemical_quantity' => ($request->uocmonth[$i] ?? '') . "_" . ($request->uocmonthyear[$i] ?? ''),
                'uocunit' => decryptId($request->uocunit[$i] ?? ''),
                'supplier_details' => decryptId($request->supplier[$i] ?? ''),
                'comply_with_classification_sds' => decryptId($request->complyWithSDS[$i] ?? ''),
                'prep_date' => DBdateformat($request->prep_date[$i] ?? null),
                'revision_date' => DBdateformat($request->revision_date[$i] ?? null),
            ];
            // dd($data);
            if ($sdsFilePath && $sdsOrgName) {
                $data['sds_file_path'] = $sdsFilePath;
                $data['sds_org_name'] = $sdsOrgName;
            }

            if ($isNew) {
                $data['created_by'] = Auth::id();
                $this->create($data);
            } else {
                $editIdVal = decryptId($editIdEncrypted);
                $data['status'] = 1;
                $data['trash'] = 'NO';
                $data['updated_by'] = Auth::id();

                $this->withoutGlobalScopes()->where('id', $editIdVal)->update($data);
            }
        }


        return true;
    }

    public function getwhere($where)
    {

        $data = $this->select('*')
            ->where($where)
            ->get();

        return $data;
    }

    protected static function booted()
    {
        static::addGlobalScope(new TrashScope('chemical_chemical_list_details'));
    }
}
