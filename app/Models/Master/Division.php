<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

use App\Models\Master\Location;
use App\Scopes\TrashScope;

class Division extends Model
{
    use  HasFactory;


    protected $table = 'master_company_division';
    protected $primaryKey = 'id';

    protected $fillable = [
        'division_id',
        'company_id',
        'division_name',
        'division_shortname',
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

        $query = $this->select('master_company_division.*', 'master_company.company_name')
            ->leftJoin('master_company', 'master_company_division.company_id', '=', 'master_company.id');

      

        $data_count = $query->count();
        $total_records = $data_count;

        $query->orderBy('id','ASC');


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
            'division_name' => $request->division_name,
            'division_shortname' => $request->division_shortname,
            'created_by' => Auth::id()
        );

        return $this->create($insert_array);
    }

    public function updates($id)
    {

        $request = request();

        $update_array = array(
            'company_id' => decryptId($request->company_id),
            'division_name' => $request->division_name,
            'division_shortname' => $request->division_shortname,
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

        $query = $this->select('master_company_division.*', 'master_company.company_name')
            ->leftJoin('master_company', 'master_company_division.company_id', '=', 'master_company.id');

       

        $query = $query->orderBy('created_at', 'Desc');
        return  $query->get();
    }

    public function selectOne($id)
    {

        $data = $this->select('master_company_division.*', 'master_company.company_name')
            ->leftJoin('master_company', 'master_company_division.company_id', '=', 'master_company.id')
            ->where('master_company_division.id', $id)
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

    public function whereget($where)
    {

        $data = $this->select('*')
            ->where($where)
            ->get();
        return $data;
    }

    public function getAllDivision()
    {
        $data = $this->select('*')->where('status', 1)
            ->get();

        return $data;
    }

    protected static function booted()
    {
        static::addGlobalScope(new TrashScope('master_company_division'));

        static::created(function ($model) {

            $uniqueId = 'DIV-' . str_pad($model->id, 5, '0', STR_PAD_LEFT);
            $model->update(['division_id' => $uniqueId]);
        });
    }
}
