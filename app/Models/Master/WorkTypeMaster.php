<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

use App\Scopes\TrashScope;

class WorkTypeMaster extends Model
{
    use  HasFactory;


    protected $table = 'master_work_type';
    protected $primaryKey = 'id';

    protected $fillable = [
        'work_type_id',
        'work_type_name',
        'supervising_authority',
        'work_type_description',
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

        $query = $this->select('master_work_type.*');

        

        $data_count = $query = $query->orderBy('id', 'ASC');
        $total_records = $data_count->count();

        if ($request->length != -1) {
            $query->offset($request->start)->limit($request->length);
        }

        $data = $query->get();
        $datas = array(
            'data' => $data,
            'total_records' => $total_records
        );

        return $datas;
    }

    public function store()
    {

        $request = request();

        $insert_array = array(
            'work_type_name' => $request->work_type_name,
            'work_type_description' => $request->work_type_description,
            'supervising_authority' => array_to_string(arrayDecrypt($request->supervising_authority)),
            'created_by' => Auth::id()
        );


        return $this->create($insert_array);
    }

    public function updates($id)
    {

        $request = request();

        $update_array = array(
            'work_type_id' => $request->work_type_id,
            'work_type_name' => $request->work_type_name,
            'work_type_description' => $request->work_type_description,
            'supervising_authority' => array_to_string(arrayDecrypt($request->supervising_authority)),
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

    public function selectOne($id)
    {

        $data =  $this->select('master_work_type.*')
            ->where('master_work_type.id', $id)
            ->first();

        return $data;
    }

    public function exportdata()
    {
        $request = request();
        $search = '';

        $query = $this->select('master_work_type.*');

      

        $query = $query->orderBy('id', 'ASC');
        return  $query->get();
    }

    public function ajaxList($companyId = '')
    {
        $query = $this->select('id', 'work_type_name')->where('status', 1);

        if ($companyId != '') {

            $query = $query->where('company_id', $companyId);
        }

        $datas = $query->get();



        $list = [];
        foreach ($datas as $data) {
            $listvalue = [];
            $listvalue['id'] = encryptId($data->id);
            $listvalue['name'] = $data->work_type_name;

            $list[] = $listvalue;
        }
        return $list;
    }

    public function getAllWorktypeData()
    {
        $data = $this->select('*')->where('status', 1)
            ->get();

        return $data;
    }

    protected static function booted()
    {
        static::addGlobalScope(new TrashScope('master_work_type'));

        static::created(function ($model) {

            $uniqueId = 'WRK-TYPE-' . str_pad($model->id, 5, '0', STR_PAD_LEFT);
            $model->update(['work_type_id' => $uniqueId]);
        });
    }
}
