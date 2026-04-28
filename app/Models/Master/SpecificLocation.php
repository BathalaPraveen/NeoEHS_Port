<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

use App\Models\Master\Location;
use App\Scopes\TrashScope;

class SpecificLocation extends Model
{
    use  HasFactory;


    protected $table = 'master_location_specific';
    protected $primaryKey = 'id';

    protected $fillable = [
        'company_id',
        'specific_location_id',
        'location_id',
        'specific_loc_name',
        'specific_loc_desc',
        'area_owner',
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

        $query = $this->select('master_location_specific.*', 'master_company.company_name', 'master_location.location_name')
            ->leftJoin('master_location', 'master_location_specific.location_id', '=', 'master_location.id')
            ->leftJoin('master_company', 'master_location_specific.company_id', '=', 'master_company.id');

        if ($request->search['value'] != null || $request->search['value'] != '') {
            $search = $request->search['value'];

            $query->where(function ($query) use ($search) {
                $query->orWhere('master_location.location_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('specific_location_id', 'LIKE', '%' . $search . '%')
                    ->orWhere('specific_loc_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('specific_loc_desc', 'LIKE', '%' . $search . '%');
            });
        }

        $data_count = $query->count();
        $total_records = $data_count;
        $data = $query->orderBy('id', 'ASC');

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
            'location_id' => decryptId($request->location_id),
            'specific_loc_name' => $request->specific_location_name,
            'specific_loc_desc' => $request->specific_location_desc,
            'area_owner' => array_to_string(arrayDecrypt($request->area_owner)),
            'created_by' => Auth::id()
        );

        return $this->create($insert_array);
    }

    public function updates($id)
    {

        $request = request();

        $update_array = array(
            'company_id' => decryptId($request->company_id),
            'specific_location_id' => $request->specific_location_id,
            'location_id' => decryptId($request->location_id),
            'specific_loc_name' => $request->specific_location_name,
            'specific_loc_desc' => $request->specific_location_desc,
            'area_owner' => array_to_string(arrayDecrypt($request->area_owner)),
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

        $query = $this->select('master_location_specific.*', 'master_location.location_name','master_company.company_name')
            ->leftJoin('master_location', 'master_location_specific.location_id', '=', 'master_location.id')
            ->leftJoin('master_company', 'master_location_specific.company_id', '=', 'master_company.id');

        if ($request->search != null || $request->search != '') {
            $search = $request->search;

            $query->where(function ($query) use ($search) {
                $query->orWhere('master_location.location_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('specific_location_id', 'LIKE', '%' . $search . '%')
                    ->orWhere('specific_loc_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('specific_loc_desc', 'LIKE', '%' . $search . '%');
            });
        }

        $query = $query->orderBy('created_at', 'Desc');
        return  $query->get();
    }

    public function selectOne($id)
    {

        $data = $this->select('master_location_specific.*', 'master_location.location_name','master_company.company_name')
            ->leftJoin('master_location', 'master_location_specific.location_id', '=', 'master_location.id')
            ->leftJoin('master_company', 'master_location_specific.company_id', '=', 'master_company.id')
            ->where('master_location_specific.id', $id)
            ->first();

        return $data;
    }

    public function ajaxList($locationId = '')
    {

        $query = $this->select('id', 'specific_loc_name')->where('status', 1);

        if ($locationId != '') {
            $query = $query->where('location_id', $locationId);
        }

        $datas = $query->get();

        $list = [];
        foreach ($datas as $data) {
            $listvalue = [];
            $listvalue['id'] = encryptId($data->id);
            $listvalue['name'] = $data->specific_loc_name;

            $list[] = $listvalue;
        }
        return $list;
    }

    public function getlocation($id)
    {

        return $this->where('location_id', $id)->where('status', 1)->get();
    }

    public function whereget($where)
    {

        $data = $this->select('*')
            ->where($where)
            ->get();
        return $data;
    }

    public function getAllSpecificLocation()
    {
        $data = $this->select('*')->where('status', 1)
            ->get();

        return $data;
    }

    public static function booted()
    {
        static::addGlobalScope(new TrashScope('master_location_specific'));

        static::created(function ($model) {

            $uniqueId = 'SPL-' . str_pad($model->id, 5, '0', STR_PAD_LEFT);
            $model->update(['specific_location_id' => $uniqueId]);
        });
    }
}
