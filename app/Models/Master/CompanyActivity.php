<?php

namespace App\Models\Master;

use App\Scopes\TrashScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompanyActivity extends Model
{
    use  HasFactory;


    protected $table = 'master_company_activity';
    protected $primaryKey = 'id';

    protected $fillable = [
        'activity_id',
        'activity_name',
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

        $query = $this->select('master_company_activity.*');

        if ($request->search['value'] != null || $request->search['value'] != '') {
            $search = $request->search['value'];

            $query =  $query->Where(function ($query) use ($search) {
                $query->orWhereRaw('activity_id LIKE "%' . $search . '%"');
                $query->orWhereRaw('activity_name LIKE "%' . $search . '%"');
            });
        }

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
            'activity_name' => $request->activity_name,
            'created_by' => Auth::id()
        );

        return $this->create($insert_array);
    }

    public function updates($id)
    {

        $request = request();

        $update_array = array(
            'activity_id' => $request->activity_id,
            'activity_name' => $request->activity_name,
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

        $data =  $this->select('master_company_activity.*')
            ->where('master_company_activity.id', $id)
            ->first();

        return $data;
    }

    public function exportdata()
    {
        $request = request();
        $search = '';

        $query = $this->select('master_company_activity.*');

        if ($request->search != null || $request->search != '') {
            $search = $request->search['value'];

            $query =  $query->Where(function ($query) use ($search) {
                $query->orWhereRaw('activity_id LIKE "%' . $search . '%"');
                $query->orWhereRaw('activity_name LIKE "%' . $search . '%"');
            });
        }

        $query = $query->orderBy('id', 'ASC');
        return  $query->get();
    }

    public function ajaxList($companyId = '')
    {
        $query = $this->select('id', 'activity_name')->where('status', 1);

        if ($companyId != '') {

            $query = $query->where('company_id', $companyId);
        }

        $datas = $query->get();



        $list = [];
        foreach ($datas as $data) {
            $listvalue = [];
            $listvalue['id'] = encryptId($data->id);
            $listvalue['name'] = $data->activity_name;

            $list[] = $listvalue;
        }
        return $list;
    }

    public function getAllActivityType()
    {
        $data = $this->select('*')->where('status', 1)
            ->get();

        return $data;
    }

    protected static function booted()
    {
        static::addGlobalScope(new TrashScope('master_company_activity'));

        static::created(function ($model) {

            $uniqueId = 'COM-ACT-' . str_pad($model->id, 5, '0', STR_PAD_LEFT);
            $model->update(['activity_id' => $uniqueId]);
        });
    }
}
