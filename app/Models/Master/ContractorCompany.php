<?php

namespace App\Models\Master;

use App\Scopes\TrashScope;
use Illuminate\Support\Str;
use App\Models\Master\Location;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContractorCompany extends Model
{
    use  HasFactory;


    protected $table = 'master_contractor_company';
    protected $primaryKey = 'id';

    protected $fillable = [
        'com_id',
        'con_comp_name',
        'con_email',
        'con_phone',

        'roc_no',
        'ssm_cerificate',
        'ssm_cerificate_path',
        'type_of_business',
        'address_1',
        'address_2',
        'postcode',
        'city',
        'state',
        'contractor_status',
        'type',

        'hse_remarks',
        'hse_time',
        'hse_name',
        'it_remarks',
        'it_time',
        'it_name',

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

    public function list()
    {
        $request = request();
        $search = '';

        $query = $this->select('master_contractor_company.*');

        
        if ($request->has('com_id') && $request->com_id) {
            $query = $query->where('com_id', 'LIKE', '%' . $request->com_id . '%');
        }
        if ($request->has('con_comp_name') && $request->con_comp_name) {
            $query = $query->where('con_comp_name', 'LIKE', '%' . $request->con_comp_name . '%');
        }
        if ($request->has('con_email') && $request->con_email) {
            $query = $query->where('con_email', 'LIKE', '%' . $request->con_email . '%');
        }
        if ($request->has('con_phone') && $request->con_phone) {
            $query = $query->where('con_phone', 'LIKE', '%' . $request->con_phone . '%');
        }

        if ($request->has('contractor_status') && $request->contractor_status) {
            $query = $query->where('contractor_status', decryptId($request->contractor_status));
        }

        if ($request->has('type') && $request->type) {
            $query = $query->where('type', decryptId($request->type));
        }

        $data_count = $query->count();
        $total_records = $data_count;

        if ($request->length != -1) {
            $query->offset($request->start)->limit($request->length);
        }
        $data = $query->orderBY('id', 'ASC');
        $data = $query->get();

        $datas = [
            'data' => $data,
            'total_records' => $total_records
        ];

        return $datas;
    }

    public function UniqueCheck($data)
    {
        return $this->where($data['param'],  $data['value'])->get();
    }

    public function ROCUniquecheck($data)
    {
        return $this->where('roc_no', $data)->count();
    }

    public function ExistROCUniquecheck($id, $data)
    {
        return $this->where('roc_no', $data)->where('id', '!=', $id)->count();
    }

    public function ExistuniqueCheck($data)
    {
        return $this->where($data['param'],  $data['value'])
            ->where('id', '!=', decryptId($data['id']))
            ->get();
    }

    public function store()
    {

        $request = request();

        $file = $request->file('ssm_cerificate');

        $uploadpath = 'public/uploads/master/contractor';

        $folderPath = public_path('uploads/master/contractor');

        if (!File::exists($folderPath)) {

            File::makeDirectory($folderPath, 0755, true);
        }

        $filenewname = time() . Str::random('20') . '.' . $file->getClientOriginalExtension();

        $file->move($uploadpath, $filenewname);

        $path = $uploadpath . "/" . $filenewname;
        $fileName = $file->getClientOriginalName();

        $insert_array = array(

            'con_comp_name' => $request->con_comp_name,
            'con_email' => $request->con_comp_email,
            'con_phone' => $request->con_comp_phone,

            'roc_no' => $request->con_comp_roc,

            'ssm_cerificate' => $fileName,
            'ssm_cerificate_path' => $path,
            'type_of_business' => $request->type_of_business,
            'address_1' => $request->address_1,
            'address_2' => $request->address_2,
            'postcode' => $request->postcode,
            'city' => $request->city,
            'state' => $request->state,
            'contractor_status' => APPROVED,
            'type' => FROM_CON_MASTER,

            'created_by' => Auth::id()
        );

        return $this->create($insert_array);
    }

    public function Register()
    {

        $request = request();

        $file = $request->file('ssm_cerificate');

        $uploadpath = 'public/uploads/master/contractor';

        $folderPath = public_path('uploads/master/contractor');

        if (!File::exists($folderPath)) {

            File::makeDirectory($folderPath, 0755, true);
        }

        $filenewname = time() . Str::random('20') . '.' . $file->getClientOriginalExtension();

        $file->move($uploadpath, $filenewname);

        $path = $uploadpath . "/" . $filenewname;
        $fileName = $file->getClientOriginalName();

        $insert_array = array(

            'con_comp_name' => $request->con_comp_name,
            'con_email' => $request->con_comp_email,
            'con_phone' => $request->con_comp_phone,
            'roc_no' => $request->con_comp_roc,

            'ssm_cerificate' => $fileName,
            'ssm_cerificate_path' => $path,
            'type_of_business' => $request->type_of_business,
            'address_1' => $request->address_1,
            'address_2' => $request->address_2,
            'postcode' => $request->postcode,
            'city' => $request->city,
            'state' => $request->state,
            'contractor_status' => HSE_ACTION_PENDING,
            'type' => FROM_REGISTRATION,

            'status' => 0,
            'created_by' => 1
        );

        return ContractorCompany::create($insert_array);
    }

    public function updates($id)
    {

        $request = request();

        $old_data = $this->where('id', $id)->first();

        $path = $old_data->ssm_cerificate_path;
        $fileName = $old_data->ssm_cerificate;

        $file = $request->file('ssm_cerificate');
        if ($file) {

            $uploadpath = 'public/uploads/master/contractor';

            $folderPath = public_path('uploads/master/contractor');

            if (!File::exists($folderPath)) {

                File::makeDirectory($folderPath, 0755, true);
            }

            $filenewname = time() . Str::random('20') . '.' . $file->getClientOriginalExtension();

            $file->move($uploadpath, $filenewname);

            $path = $uploadpath . "/" . $filenewname;
            $fileName = $file->getClientOriginalName();
        }

        $update_array = array(
            'com_id' => $request->con_comp_id,
            'con_comp_name' => $request->con_comp_name,
            'con_email' => $request->con_comp_email,
            'con_phone' => $request->con_comp_phone,

            'roc_no' => $request->con_comp_roc,

            'ssm_cerificate' => $fileName,
            'ssm_cerificate_path' => $path,
            'type_of_business' => $request->type_of_business,
            'address_1' => $request->address_1,
            'address_2' => $request->address_2,
            'postcode' => $request->postcode,
            'city' => $request->city,
            'state' => $request->state,
            'contractor_status' => APPROVED,
            'type' => FROM_CON_MASTER,

            'updated_by' => Auth::id()
        );

        return $this->where('id', $id)->update($update_array);
    }

    public function hse_approval($id)
    {

        $request = request();

        if ($request->action == 1) {
            $status = IT_DEPT_ACTION_PENDING;
        } else {
            $status = HSE_REJECTED;
        }

        $update_array = array(
            'hse_name' => Auth::id(),
            'hse_time' => DBdatetimeformat(Carbon::now()),
            'hse_remarks' => $request->hse_remarks,
            'contractor_status' => $status,
            'updated_by' => Auth::id()
        );

        return $this->where('id', $id)->update($update_array);
    }

    public function it_approval($id)
    {

        $request = request();

        $status = ($request->action == 1) ? APPROVED : IT_DEPT_REJECTED;

        $update_array = [
            'it_name' => Auth::id(),
            'it_time' => DBdatetimeformat(Carbon::now()),
            'it_remarks' => $request->it_remarks,
            'contractor_status' => $status,
            'updated_by' => Auth::id()
        ];

        if ($request->action == 1) {
            $update_array['status'] = 1;
        }

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

        $query = $this->select('master_contractor_company.*');

        

        if ($request->has('com_id') && $request->com_id) {
            $query = $query->where('com_id', 'LIKE', '%' . $request->com_id . '%');
        }

        if ($request->has('con_comp_name') && $request->con_comp_name) {
            $query = $query->where('con_comp_name', 'LIKE', '%' . $request->con_comp_name . '%');
        }

        if ($request->has('con_email') && $request->con_email) {
            $query = $query->where('con_email', 'LIKE', '%' . $request->con_email . '%');
        }

        if ($request->has('con_phone') && $request->con_phone) {
            $query = $query->where('con_phone', 'LIKE', '%' . $request->con_phone . '%');
        }

        if ($request->has('contractor_status') && $request->contractor_status) {
            $query = $query->where('contractor_status', decryptId($request->contractor_status));
        }

        if ($request->has('type') && $request->type) {
            $query = $query->where('type', decryptId($request->type));
        }

        $query = $query->orderBy('created_at', 'Desc');
        return  $query->get();
    }

    public function selectOne($id)
    {

        $data = $this->select('master_contractor_company.*')
            ->where('master_contractor_company.id', $id)
            ->first();

        return $data;
    }

    public function ajaxList($company_id = '')
    {

        $query = $this->select('id', 'division_name');

        if ($company_id != '') {
            $query = $query->where('company_id', $company_id);
        }

        $datas = $query->get();

        $list = [];
        foreach ($datas as $data) {
            $listvalue = [];
            $listvalue['id'] = encryptId($data->id);
            $listvalue['name'] = $data->division_name;

            $list[] = $listvalue;
        }

        return $list;
    }

    public function CreateNew()
    {

        $request = request();

        $insert_array = array(

            'com_id' => getsequence('contractorcompanny'),
            'con_comp_name' => $request->con_company_other,
            'con_email' => $request->con_email_id,
            'con_phone' => $request->con_phone_no,
            'created_by' => Auth::id()
        );

        return $this->create($insert_array);
    }

    protected static function booted()
    {
        static::addGlobalScope(new TrashScope('master_contractor_company'));

        static::created(function ($model) {

            $uniqueId = 'COC' . str_pad($model->id, 5, '0', STR_PAD_LEFT);
            $model->update(['com_id' => $uniqueId]);
        });
    }
}
