<?php

namespace App\Models\WasteManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


use App\Scopes\TrashScope;

class WasteList extends Model
{
    use  HasFactory;


    protected $table = 'wastemanagement_waste_list';
    protected $primaryKey = 'id';

    protected $fillable = [
        'waste_entry_id',
        'company_id',
        'location_id',
        'specific_location_id',
        'remarks',
        'waste_disposal_status',
        'total_waste',
        'total_weight',
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

        $query = $this->select('wastemanagement_waste_list.*', 'master_location.location_name', 'master_company.company_name')
            ->leftJoin('master_location', 'wastemanagement_waste_list.location_id', '=', 'master_location.id')
            ->leftJoin('master_company', 'wastemanagement_waste_list.company_id', '=', 'master_company.id');

        if ($request->search['value'] != null || $request->search['value'] != '') {
            $search = $request->search['value'];

            $query->where(function ($query) use ($search) {
                $query->orWhere('wastemanagement_waste_list.chemical_name', 'LIKE', '%' . $search . '%');
            });
        }

        $data_count = $query->count();
        $total_records = $data_count;

        $query->orderBy('id', 'DESC');


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
            'company_id' => decryptId($request->company),
            'location_id' => decryptId($request->location),
            'remarks' => $request->reporter_remarks,
            'waste_disposal_status' => WASTE_STATUS_GHSE_PENDING,
            'total_waste' => json_encode($request->total),
            'total_weight' => $request->total_weight,
            'created_by' => Auth::id()
        );

        return $this->create($insert_array);
    }

    public function updates($id)
    {

        $request = request();

        $update_array = array(
            'company_id' => decryptId($request->company),
            'location_id' => decryptId($request->location),
            'remarks' => $request->reporter_remarks,
            'waste_disposal_status' => 1,
            'total_waste' => json_encode($request->total),
            'total_weight' => $request->total_weight,
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

        $query = $this->select('wastemanagement_waste_list.*', 'master_location.location_name', 'master_company.company_name')
            ->leftJoin('master_location', 'wastemanagement_waste_list.location_id', '=', 'master_location.id')
            ->leftJoin('master_company', 'wastemanagement_waste_list.company_id', '=', 'master_company.id');

        if ($request->search != null || $request->search != '') {
            $search = $request->search;

            $query->where(function ($query) use ($search) {
                $query->orWhere('wastemanagement_waste_list.chemical_name', 'LIKE', '%' . $search . '%');
            });
        }

        $query = $query->orderBy('id', 'Desc');
        return  $query->get();
    }

    public function selectOne($id)
    {

        $data = $this->select('wastemanagement_waste_list.*', 'master_location.location_name', 'master_company.company_name')
            ->leftJoin('master_location', 'wastemanagement_waste_list.location_id', '=', 'master_location.id')
            ->leftJoin('master_company', 'wastemanagement_waste_list.company_id', '=', 'master_company.id')
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
        static::addGlobalScope(new TrashScope('wastemanagement_waste_list'));

        static::created(function ($model) {

            $uniqueId = 'WASTE-' . str_pad($model->id, 5, '0', STR_PAD_LEFT);
            $model->update(['waste_entry_id' => $uniqueId]);
        });
    }
}
