<?php

namespace App\Models\HIRADC;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


use App\Scopes\TrashScope;

class ProcessTypeDetails extends Model
{
    use  HasFactory;


    protected $table = 'hiradc_master_process_type_details';
    protected $primaryKey = 'id';

    protected $fillable = [
        'process_type_id',
        'sub_type_name',
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

        $query = $this->select('hiradc_master_process_type_details.*','hiradc_master_process_type.process_type_name');
        $query = $query->leftJoin('hiradc_master_process_type', 'hiradc_hiradc_list_details.process_type_id', '=', 'hiradc_master_process_type.id');

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

    public function exportdata()
    {
        $request = request();
        $search = '';

        $query = $this->select('hiradc_master_process_type_details.*','hiradc_master_process_type.process_type_name');
        $query = $query->leftJoin('hiradc_master_process_type', 'hiradc_hiradc_list_details.process_type_id', '=', 'hiradc_master_process_type.id');

        if ($request->search != null || $request->search != '') {
            $search = $request->search;

            $query->where(function ($query) use ($search) {
                $query->orWhere('sub_type_name', 'LIKE', '%' . $search . '%');
                $query->orWhere('hiradc_master_process_type.process_type_name', 'LIKE', '%' . $search . '%');
            });
        }

        $query = $query->orderBy('id', 'Desc');
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

    protected static function booted()
    {
        static::addGlobalScope(new TrashScope('hiradc_master_process_type_details'));
    }
}
