<?php

namespace App\Models\ATAR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


use App\Scopes\TrashScope;

class ActionTaken extends Model
{
    use  HasFactory;


    protected $table = 'atar_master_action_taken';
    protected $primaryKey = 'id';

    protected $fillable = [
        'atar_type',
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

        $query = $this->select('atar_master_action_taken.*');

        if ($request->search['value'] != null || $request->search['value'] != '') {
            $search = $request->search['value'];

            $query->where(function ($query) use ($search) {

                $query->orWhere('atar_type', 'LIKE', '%' . $search . '%');

            });
        }

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

        $query = $this->select('*');

        if ($request->search != null || $request->search != '') {
            $search = $request->search;

            $query->where(function ($query) use ($search) {
                $query->orWhere('type_name', 'LIKE', '%' . $search . '%');
                $query->orWhere('atar_type', 'LIKE', '%' . $search . '%');
            });
        }

        $query = $query->orderBy('id', 'Asc');
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
        static::addGlobalScope(new TrashScope('atar_master_action_taken'));


    }
}
