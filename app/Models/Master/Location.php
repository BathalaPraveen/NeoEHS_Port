<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

use App\Scopes\TrashScope;

class Location extends Model
{
    use  HasFactory;


    protected $table = 'master_location';
    protected $primaryKey = 'id';

    protected $fillable = [
        'company_id',
        'location_id',
        'location_name',
        'location_shortname',
        'location_email',
        'location_phone',
        'location_mobile',
        'location_address',
        'location_zipcode',
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

        $query = $this->select('master_location.*', 'master_company.company_name')
            ->leftJoin('master_company', 'master_location.company_id', '=', 'master_company.id');

        if ($request->search['value'] != null || $request->search['value'] != '') {
            $search = $request->search['value'];

            $query =  $query->Where(function ($query) use ($search) {
                $query->orWhereRaw('location_id LIKE "%' . $search . '%"');
                $query->orWhereRaw('location_name LIKE "%' . $search . '%"');
                $query->orWhereRaw('location_shortname LIKE "%' . $search . '%"');
                $query->orWhereRaw('master_company.company_name LIKE "%' . $search . '%"');
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
            'company_id' => decryptId($request->company_id),
            'location_name' => $request->location_name,
            'location_address' => $request->location_address,
            'created_by' => Auth::id()
        );
        return $this->create($insert_array);
    }

    public function updates($id)
    {

        $request = request();

        $update_array = array(
            'company_id' => decryptId($request->company_id),
            'location_id' => $request->location_id,
            'location_name' => $request->location_name,
            'location_address' => $request->location_address,
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

    public function getcompany($id)
    {

        return $this->where('company_id', $id)->where('status', 1)->get();
    }

    public function selectOne($id)
    {

        $data =  $this->select('master_location.*', 'master_company.company_name')
            ->leftJoin('master_company', 'master_location.company_id', '=', 'master_company.id')
            ->where('master_location.id', $id)
            ->first();

        return $data;
    }

    public function exportdata()
    {
        $request = request();
        $search = '';

        $query = $this->select('master_location.*', 'master_company.company_name')
            ->leftJoin('master_company', 'master_location.company_id', '=', 'master_company.id');

        if ($request->search != null || $request->search != '') {
            $search = $request->search['value'];

            $query =  $query->Where(function ($query) use ($search) {
                $query->orWhereRaw('location_id LIKE "%' . $search . '%"');
                $query->orWhereRaw('location_name LIKE "%' . $search . '%"');
                $query->orWhereRaw('master_company.company_name LIKE "%' . $search . '%"');
            });
        }

        $query = $query->orderBy('id', 'ASC');
        return  $query->get();
    }

    public function ajaxList($companyId = '')
    {
        $query = $this->select('id', 'location_name')->where('status', 1);

        if ($companyId != '') {

            $query = $query->where('company_id', $companyId);
        }

        $datas = $query->get();



        $list = [];
        foreach ($datas as $data) {
            $listvalue = [];
            $listvalue['id'] = encryptId($data->id);
            $listvalue['name'] = $data->location_name;

            $list[] = $listvalue;
        }
        return $list;
    }

    public function getAllLocation()
    {
        $data = $this->select('*')->where('status', 1)
            ->get();

        return $data;
    }

    protected static function booted()
    {
        static::addGlobalScope(new TrashScope('master_location'));

        static::created(function ($model) {

            $uniqueId = 'LOC-' . str_pad($model->id, 5, '0', STR_PAD_LEFT);
            $model->update(['location_id' => $uniqueId]);
        });
    }
}
