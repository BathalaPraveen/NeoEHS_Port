<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

use App\Models\Master\Location;
use App\Scopes\TrashScope;

class Department extends Model
{
    use  HasFactory;


    protected $table = 'master_company_department';
    protected $primaryKey = 'id';

    protected $fillable = [
        'department_id',
        'division_id',
        'company_id',
        'department_name',
        'department_shortname',
        'dept_admin',
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

        $query = $this->select('master_company_department.*', 'master_company.company_name', 'master_company_division.division_name')
            ->leftJoin('master_company', 'master_company_department.company_id', '=', 'master_company.id')
            ->leftJoin('master_company_division', 'master_company_department.division_id', '=', 'master_company_division.id');

        if ($request->search['value'] != null || $request->search['value'] != '') {
            $search = $request->search['value'];

            $query->where(function ($query) use ($search) {
                $query->orWhere('master_company.company_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('master_company_division.division_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('department_id', 'LIKE', '%' . $search . '%')
                    ->orWhere('department_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('department_shortname', 'LIKE', '%' . $search . '%');
            });
        }

        $data_count = $query->count();
        $total_records = $data_count;

        $query->orderBy('id', 'ASC');


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

    public function store()
    {

        $request = request();

        $insert_array = array(

            'company_id' => decryptId($request->company_id),
            'division_id' => decryptId($request->division_id),
            'department_name' => $request->department_name,
            'department_shortname' => $request->department_shortname,
            'dept_admin' => array_to_string(arrayDecrypt($request->dept_admin)),
            'created_by' => Auth::id()
        );


        return $this->create($insert_array);
    }

    public function updates($id)
    {

        $request = request();

        $update_array = array(
            'department_id' => $request->department_id,
            'company_id' => decryptId($request->company_id),
            'division_id' => decryptId($request->division_id),
            'department_name' => $request->department_name,
            'department_shortname' => $request->department_shortname,
            'dept_admin' => array_to_string(arrayDecrypt($request->dept_admin)),
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

        $query = $this->select('master_company_department.*', 'master_company.company_name', 'master_company_division.division_name')
            ->leftJoin('master_company', 'master_company_department.company_id', '=', 'master_company.id')
            ->leftJoin('master_company_division', 'master_company_department.division_id', '=', 'master_company_division.id');

        if ($request->search != null || $request->search != '') {
            $search = $request->search;

            $query->where(function ($query) use ($search) {
                $query->orWhere('master_company.company_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('division_id', 'LIKE', '%' . $search . '%')
                    ->orWhere('division_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('division_shortname', 'LIKE', '%' . $search . '%');
            });
        }

        $query = $query->orderBy('created_at', 'Desc');
        return  $query->get();
    }

    public function selectOne($id)
    {

        $data = $this->select('master_company_department.*', 'master_company.company_name', 'master_company_division.division_name')
            ->leftJoin('master_company', 'master_company_department.company_id', '=', 'master_company.id')
            ->leftJoin('master_company_division', 'master_company_department.division_id', '=', 'master_company_division.id')
            ->where('master_company_department.id', $id)
            ->first();

        return $data;
    }

    public function getjobowner()
    {

        $data = $this->select('master_company_department.*', 'master_company.company_name')
            ->leftJoin('master_company', 'master_company_department.company_id', '=', 'master_company.id')
            ->where('master_company_department.status', 1)
            ->get();

        return $data;
    }

    public function ajaxList($divisionId = '')
    {

        $query = $this->select('id', 'department_name')->where('status', 1);

        if ($divisionId != '') {
            $query = $query->where('division_id', $divisionId);
        }

        $datas = $query->get();

        $list = [];
        foreach ($datas as $data) {
            $listvalue = [];
            $listvalue['id'] = encryptId($data->id);
            $listvalue['name'] = $data->department_name;

            $list[] = $listvalue;
        }

        return $list;
    }

    public function whereget($where)
    {

        $data = $this->select('*')
            ->where($where)
            ->get();
        return $data;
    }

    public function getAllDepartment()
    {
        $data = $this->select('*')->where('status', 1)
            ->get();

        return $data;
    }

    protected static function booted()
    {
        static::addGlobalScope(new TrashScope('master_company_department'));


        static::created(function ($model) {

            $uniqueId = 'DEP-' . str_pad($model->id, 5, '0', STR_PAD_LEFT);
            $model->update(['department_id' => $uniqueId]);
        });
    }
}
