<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

use App\Models\Master\Location;
use App\Scopes\TrashScope;

class Contractor extends Model
{
    use  HasFactory;


    protected $table = 'master_contractor';
    protected $primaryKey = 'id';

    protected $fillable = [
        'login_id',
        'cont_id',
        'cont_name',
        'cont_company_id',
        'cont_email',
        'cont_special',
        'cont_phone',
        'cont_address',
        'cont_city',
        'cont_country',
        'cont_postal_code',
        'cont_dob',
        'cont_gender',
        'cont_nationality',
        'cont_nationality_other',
        'cont_designation',
        'cont_id_type',
        'cont_id_number',
        'cont_otp_mobile',
        'con_login_status',
        'cert_status',
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

        $query = $this->select('master_contractor.*', 'master_contractor_company.con_comp_name')
            ->leftJoin('master_contractor_company', 'master_contractor.cont_company_id', '=', 'master_contractor_company.id');


        if ($request->con_company_id != '' && $request->con_company_id != null) {
            $con_company_id = decryptId($request->con_company_id);
            $query->where('master_contractor.cont_company_id', $con_company_id);
        }

        if ($request->con_status != '' && $request->con_status != null) {
            $con_status = decryptId($request->con_status);
            $query->where('master_contractor.status', $con_status);
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

    public function ExistuniqueCheck($data)
    {
        return $this->where($data['param'],  $data['value'])
            ->where('id', '!=', decryptId($data['id']))
            ->get();
    }

    public function store($id, $companyId = '')
    {

        $request = request();

        if ($companyId == '') {
            $companyId = decryptId($request->con_company_id);
        }

        $insert_array = array(
            'login_id' => $id,
            'cont_id' => $request->con_id,
            'cont_name' => $request->con_name,
            'cont_gender' => decryptId($request->con_gender),
            'cont_company_id' => $companyId,
            'cont_email' => $request->con_email_id,
            'cont_phone' => $request->con_phone_no,
            'cont_nationality' => decryptId($request->con_nationality),
            'cont_nationality_other' => $request->con_nationality_other,
            'cont_designation' => $request->con_designation_id,
            'cont_id_type' => decryptId($request->id_type),
            'cont_id_number' => $request->con_mc_or_passport_no,
            'con_login_status' => 'P',
            'created_by' => Auth::id()
        );

        return $this->create($insert_array);
    }


    public function register($id, $companyId)
    {

        $request = request();

        $con_id = getsequence('contractor');

        $insert_array = array(
            'login_id' => $id,
            'cont_id' => $con_id,
            'cont_name' => $request->pic_name,
            // 'cont_gender' => decryptId($request->con_gender),
            'cont_company_id' => $companyId,
            'cont_email' => $request->pic_email,
            'cont_phone' => $request->con_phone_no,
            // 'cont_nationality' => decryptId($request->con_nationality),
            // 'cont_nationality_other' => $request->con_nationality_other,
            'cont_designation' => $request->pic_designation,
            'cont_id_type' => decryptId($request->id_type),
            'cont_id_number' => $request->con_mc_or_passport_no,
            'con_login_status' => 'P',
            'status' => 0,
            'created_by' => 1
        );


        return $this->create($insert_array);
    }

    public function updates($id, $companyId = '')
    {

        $request = request();

        if ($companyId == '') {
            $companyId = decryptId($request->con_company_id);
        }

        $update_array = array(
            'cont_name' => $request->con_name,
            'cont_gender' => decryptId($request->con_gender),
            'cont_company_id' => $companyId,
            'cont_email' => $request->con_email_id,
            'cont_phone' => $request->con_phone_no,
            'cont_nationality' => decryptId($request->con_nationality),
            'cont_nationality_other' => $request->con_nationality_other,
            'cont_designation' => $request->con_designation_id,
            'cont_id_type' => decryptId($request->id_type),
            'cont_id_number' => $request->con_mc_or_passport_no,
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

        $query = $this->select(
            'master_contractor.*',
            'master_contractor_company.con_comp_name',
            'master_nationality.nationality',
            'master_gender.gender_name'
        )
            ->leftJoin('master_contractor_company', 'master_contractor.cont_company_id', '=', 'master_contractor_company.id')
            ->leftJoin('master_nationality', 'master_contractor.cont_nationality', '=', 'master_nationality.id')
            ->leftJoin('master_gender', 'master_contractor.cont_gender', '=', 'master_gender.id');

        if ($request->con_company_id != '' && $request->con_company_id != null) {
            $con_company_id = decryptId($request->con_company_id);
            $query->where('master_contractor.cont_company_id', $con_company_id);
        }

        if ($request->con_status != '' && $request->con_status != null) {
            $con_status = decryptId($request->con_status);
            $query->where('master_contractor.status', $con_status);
        }

        

        $query = $query->orderBy('created_at', 'Desc');
        return  $query->get();
    }

    public function selectOne($id)
    {

        $data = $this->select('master_contractor.*', 'master_contractor_company.con_comp_name',   'master_nationality.nationality', 'master_gender.gender_name')
            ->leftJoin('master_contractor_company', 'master_contractor.cont_company_id', '=', 'master_contractor_company.id')
            ->leftJoin('master_nationality', 'master_contractor.cont_nationality', '=', 'master_nationality.id')
            ->leftJoin('master_gender', 'master_contractor.cont_gender', '=', 'master_gender.id')
            ->where('master_contractor.id', $id)
            ->first();

        return $data;
    }

    public function ajaxList($company_id = '')
    {

        $query = $this->select('id', 'division_name')->where('status', 1);

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

    public function getEmployeeUsingCompId($id)
    {
        $data = $this->where('cont_company_id', $id)->first();
        return $data;
    }

    public function enableEmployee($id)
    {

        $update_data = array(
            'status' => 1,
        );

        return $this->where('id', $id)->update($update_data);
    }


    protected static function booted()
    {
        static::addGlobalScope(new TrashScope('master_contractor'));

        static::created(function ($model) {

            $uniqueId = 'CON' . str_pad($model->id, 5, '0', STR_PAD_LEFT);
            $model->update(['cont_id' => $uniqueId]);
        });
    }
}

