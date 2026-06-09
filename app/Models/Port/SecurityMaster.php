<?php

namespace App\Models\Port;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


use App\Scopes\TrashScope;

class SecurityMaster extends Model
{
    use  HasFactory;


    protected $table = SECMAS;
    protected $primaryKey = 'id';

    protected $fillable = [
        'unique_id',
        'name',
        'id_type',
        'passport_number',
        'company_id',
        'designation_id',
        'location_id',
        'induction_date',
        'induction_duedate',
        'vehicle_type',
        'vehicle_number',
        'purpose',
        'vehicle_entry_date',
        'vehicle_entry_time',
        'vehicle_exit_date',
        'vehicle_exit_time',
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
        $query = $this->select(SECMAS .'.*', 'master_company.company_name', 'master_location.location_name', 'master_designation.designation_name')
            ->leftJoin('master_company', SECMAS .'.company_id', '=', 'master_company.id')
            ->leftJoin('master_location', SECMAS .'.location_id', '=', 'master_location.id')
            ->leftJoin('master_designation',SECMAS . '.designation_id', '=', 'master_designation.id');

        if ($request->passport_id != '' && $request->passport_id != null) {
            $passportId = $request->passport_id;
            $query->where(SECMAS .'.passport_number', $passportId);
        }
        if ($request->sec_name != '' && $request->sec_name != null) {
            $sec_name = $request->sec_name;
            $query->where(SECMAS .'.name', $sec_name);
        }
        $query = $query->orderBy('id', 'Desc');
        $data_count = $query->count();
        $total_records = $data_count;
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
       public function selectOne($id)
    {

        $data = $this->select('*')
            ->where('id', $id)
            ->first();

        return $data;
    }

    public function getall()
    {
        return $this->where('trash', 'NO')->get();
    }
    public function store()
    {
        $request = request();
        $insert_array = array(
            'unique_id'         => $request->unique_id,
            'name'              => $request->name,
            'id_type'           => $request->id_type,
            'passport_number'   => $request->passport_number,
            'company_id'        => decryptId($request->company_id),
            'location_id'          => decryptId($request->location),
            'designation_id'    => decryptId($request->designation_id),
            'induction_date'    => DBdateformat($request->induction_date),
            'induction_duedate' => DBdateformat($request->induction_duedate),
            'created_by'        => Auth::id()
        );
        return $this->insertGetId($insert_array);
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

        $query = $this->select(SECMAS .'.*', 'master_company.company_name', 'master_location.location_name', 'master_designation.designation_name')
            ->leftJoin('master_company', SECMAS .'.company_id', '=', 'master_company.id')
            ->leftJoin('master_location', SECMAS .'.location_id', '=', 'master_location.id')
            ->leftJoin('master_designation',SECMAS . '.designation_id', '=', 'master_designation.id');

        // Filter
         if ($request->passport_id != '' && $request->passport_id != null) {
            $passportId = $request->passport_id;
            $query->where(SECMAS .'.passport_number', $passportId);
        }
        if ($request->sec_name != '' && $request->sec_name != null) {
            $sec_name = $request->sec_name;
            $query->where(SECMAS .'.name', $sec_name);
        }
        $query = $query->orderBy('id', 'Desc');
        return  $query->get();
    }
    // public function selectOneWhere($where)
    // {

    //     $data = $this->select('*')
    //         ->where($where)
    //         ->first();

    //     return $data;
    // }

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
        static::addGlobalScope(new TrashScope(SECMAS));
    }
}
