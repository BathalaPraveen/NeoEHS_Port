<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

use App\Scopes\TrashScope;

class Company extends Model
{
    use  HasFactory;


    protected $table = 'master_company';
    protected $primaryKey = 'id';

    protected $fillable = [
        'company_id',
        'company_name',
        'company_shortname',
        'full_name',
        'address',
        'city',
        'pincode',
        'state',
        'telephone',
        'email',
        'dosh_reg_no',
        'roc_no',
        'code_of_sector',
        'class_of_industry',
        'company_activity',
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

        $query = $this->select('*');

       

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
            'full_name' => $request->company_name,
            'company_name' => $request->company_name,
            'company_shortname' => $request->company_shortname,

            'roc_no' => $request->roc_no,
            'dosh_reg_no' => $request->dosh_reg_no,

            'created_by' => Auth::id()
        );

        return $this->create($insert_array);
    }

    public function updates($id)
    {

        $request = request();

        $update_array = array(
            'company_id' => $request->company_id,
            'full_name' => $request->company_name,
            'company_name' => $request->company_name,
            'company_shortname' => $request->company_shortname,

            'roc_no' => $request->roc_no,
            'dosh_reg_no' => $request->dosh_reg_no,

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

        $query = $this->select('*');

      
        $query = $query->orderBy('created_at', 'Desc');
        return  $query->get();
    }

    public function selectOne($id)
    {

        $data = $this->select('*')
            ->where('id', $id)
            ->first();

        return $data;
    }

    public function selectOneWhere($where)
    {

        $data = $this->select('*')
            ->where($where)
            ->first();

        return $data;
    }

    public function getAllCompany()
    {
        $data = $this->select('*')->where('status', 1)
            ->get();

        return $data;
    }

    public function ROCUniquecheck($data)
    {
        return $this->where('roc_no', $data)->count();
    }

    public function ExistROCUniquecheck($id, $data)
    {
        return $this->where('roc_no', $data)->where('id', '!=', $id)->count();
    }

    public static function booted()
    {
        static::addGlobalScope(new TrashScope('master_company'));

        static::created(function ($model) {

            $uniqueId = 'COM-' . str_pad($model->id, 5, '0', STR_PAD_LEFT);
            $model->update(['company_id' => $uniqueId]);
        });
    }
}

