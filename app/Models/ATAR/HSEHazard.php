<?php

namespace App\Models\ATAR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


use App\Scopes\TrashScope;

class HSEHazard extends Model
{
    use  HasFactory;


    protected $table = 'atar_master_hse_hazard';
    protected $primaryKey = 'id';

    protected $fillable = [
        'atar_type',
        'hse_hazard',
        'hover_msg',
        'zefa_rule',
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

        $query = $this->select('atar_master_hse_hazard.*',  'atar_master_zefa_rules.zefa_rule','atar_master_atar_types.atar_type')
            ->leftJoin('atar_master_atar_types', 'atar_master_hse_hazard.atar_type', '=', 'atar_master_atar_types.id')
            ->leftJoin('atar_master_zefa_rules', 'atar_master_hse_hazard.zefa_rule', '=', 'atar_master_zefa_rules.id');

        if ($request->search['value'] != null || $request->search['value'] != '') {
            $search = $request->search['value'];

            $query->where(function ($query) use ($search) {

                $query->orWhere('atar_master_zefa_rules.zefa_rule', 'LIKE', '%' . $search . '%');
                $query->orWhere('hse_hazard', 'LIKE', '%' . $search . '%');
                $query->orWhere('hover_msg', 'LIKE', '%' . $search . '%');
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

    public function store()
    {

        $request = request();

        $insert_array = array(

            'atar_type' => decryptId($request->atar_type),
            'zefa_rule' => decryptId($request->zefa_rule),
            'hse_hazard' => $request->hse_hazard,
            'hover_msg' => $request->hover_message,
            'created_by' => Auth::id()
        );

        return $this->create($insert_array);
    }

    public function updates($id)
    {

        $request = request();

        $update_array = array(
            'atar_type' => decryptId($request->atar_type),
            'zefa_rule' => decryptId($request->zefa_rule),
            'hse_hazard' => $request->hse_hazard,
            'hover_msg' => $request->hover_message,
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

        $query = $this->select('atar_master_hse_hazard.*',  'atar_master_zefa_rules.zefa_rule')
            ->leftJoin('atar_master_atar_types', 'atar_master_hse_hazard.atar_type', '=', 'atar_master_atar_types.id')
            ->leftJoin('atar_master_zefa_rules', 'atar_master_hse_hazard.zefa_rule', '=', 'atar_master_zefa_rules.id');

        if ($request->search != null || $request->search != '') {
            $search = $request->search;

            $query->where(function ($query) use ($search) {

                $query->orWhere('atar_master_zefa_rules.zefa_rule', 'LIKE', '%' . $search . '%');
                $query->orWhere('hse_hazard', 'LIKE', '%' . $search . '%');
                $query->orWhere('hover_msg', 'LIKE', '%' . $search . '%');
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


    public function ajaxList($useeId = '')
    {

        $query = $this->select('atar_master_hse_hazard.*',  'atar_master_zefa_rules.zefa_rule')
            ->leftJoin('atar_master_zefa_rules', 'atar_master_hse_hazard.zefa_rule', '=', 'atar_master_zefa_rules.id');

        if ($useeId != '') {
            $query = $query->where('atar_master_hse_hazard.atar_type', $useeId);
        }

        $datas = $query->get();

        $list = [];
        foreach ($datas as $data) {
            $listvalue = [];
            $listvalue['id'] = encryptId($data->id);
            $listvalue['name'] = $data->hse_hazard;
            $listvalue['hover_msg'] = $data->hover_msg;
            $listvalue['zefa_rule'] = $data->zefa_rule;

            $list[] = $listvalue;
        }
        return $list;
    }

    public function ajaxListAPI($useeId = '')
    {

        $query = $this->select('atar_master_hse_hazard.*',  'atar_master_zefa_rules.zefa_rule')
            ->leftJoin('atar_master_zefa_rules', 'atar_master_hse_hazard.zefa_rule', '=', 'atar_master_zefa_rules.id');

        if ($useeId != '') {
            $query = $query->where('atar_master_hse_hazard.atar_type', $useeId);
        }

        $datas = $query->get();

        $list = [];
        foreach ($datas as $data) {
            $listvalue = [];
            $listvalue['id'] = $data->id;
            $listvalue['name'] = $data->hse_hazard;
            $listvalue['description'] = $data->hover_msg;
            $listvalue['zefa_rule'] = $data->zefa_rule;

            $list[] = $listvalue;
        }
        return $list;
    }

    protected static function booted()
    {
        static::addGlobalScope(new TrashScope('atar_master_hse_hazard'));
    }
}
