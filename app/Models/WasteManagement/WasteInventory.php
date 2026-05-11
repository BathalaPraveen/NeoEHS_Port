<?php

namespace App\Models\WasteManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


use App\Scopes\TrashScope;

class WasteInventory extends Model
{
    use  HasFactory;


    protected $table = 'wastemanagement_waste_inventory';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'company_id',
        'waste_code',
        'generation_date',
        'location',
        'quantity',
        'type_of_packing',
        'estimated_weight',
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

        $query = $this->select(
            'wastemanagement_waste_inventory.*',
            'wastemanagement_master_wastetype.wastetype_id',
            'wastemanagement_master_wastetype.wastetype_name',
        )
            ->join('wastemanagement_master_wastetype', 'wastemanagement_master_wastetype.id', '=', 'wastemanagement_waste_inventory.waste_code');

        $companyid = getCompanyId($request->company);
        $query->where('wastemanagement_waste_inventory.company_id', $companyid);

        if ($request->has('wastetype') && $request->wastetype != null) {
            $query->where('wastemanagement_waste_inventory.waste_code', decryptId($request->wastetype));
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
            'wastetype_id' => $request->type_id,
            'wastetype_name' => $request->type_name,
            'created_by' => Auth::id()
        );

        return $this->create($insert_array);
    }

    public function updates($id)
    {

        $request = request();

        $update_array = array(
            'wastetype_id' => $request->type_id,
            'wastetype_name' => $request->type_name,
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

        $query = $this->select(
            'wastemanagement_waste_inventory.*',
            'wastemanagement_master_wastetype.wastetype_id',
            'wastemanagement_master_wastetype.wastetype_name',
            'wastemanagement_master_item.item_name',
            'wastemanagement_master_disposaltype.disposaltype_name',
        )
            ->join('wastemanagement_master_wastetype', 'wastemanagement_master_wastetype.id', '=', 'wastemanagement_waste_inventory.waste_code')
            ->join('wastemanagement_master_item', 'wastemanagement_master_item.id', '=', 'wastemanagement_waste_inventory.location')
            ->join('wastemanagement_master_disposaltype', 'wastemanagement_master_disposaltype.id', '=', 'wastemanagement_waste_inventory.type_of_packing');

        $companyid = getCompanyId($request->company);
        $query->where('wastemanagement_waste_inventory.company_id', $companyid);

        if ($request->has('wastetype') && $request->wastetype != null) {
            $query->where('wastemanagement_waste_inventory.waste_code', decryptId($request->wastetype));
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

    public function ajaxList($activity = '')
    {

        $query = $this->select('id', 'wastetype_name');

        if ($activity != '') {
            $query = $query->where('wastetype_id', $activity);
        }

        $datas = $query->get();

        $list = [];
        foreach ($datas as $data) {
            $listvalue = [];
            $listvalue['id'] = encryptId($data->id);
            $listvalue['name'] = $data->wastetype_name;

            $list[] = $listvalue;
        }
        return $list;
    }

    public function getWhere($where)
    {

        $query = $this->select('*');

        if ($where != '') {
            $query = $query->where($where);
        }
        $datas = $query->first();

        return $datas;
    }


    public function getDetails($where)
    {

        $query = $this->select(
            'wastemanagement_waste_inventory.*',
            'wastemanagement_master_wastetype.wastetype_id',
            'wastemanagement_master_wastetype.wastetype_name',
        )->join('wastemanagement_master_wastetype', 'wastemanagement_master_wastetype.id', '=', 'wastemanagement_waste_inventory.waste_code');

        if ($where != '') {
            $query = $query->where($where);
        }

        $datas = $query->get();

        return $datas;
    }



    public function additems()
    {

        $request = request();
        $wastedetails = $request->wasteadd;

        foreach ($wastedetails as $waste) {
            $waste = (object)$waste;
            $insert_array = array(
                'company_id' => getCompanyId($request->companyname),
                'waste_code' => decryptId($waste->waste_code),
                'generation_date' => DBdateformat($waste->generation_date),
                'location' => decryptId($waste->location),
                'quantity' => $waste->quantity,
                'type_of_packing' => decryptId($waste->type_of_packaging),
                'estimated_weight' => $waste->estimated_weight,
                'created_by' => Auth::id()
            );

            $this->create($insert_array);
        }


        return true;
    }


    public function removeitems()
    {

        $request = request();


        $wastelistdetails = $request->wastesdisposal;

        foreach ($wastelistdetails as $waste) {

            $waste = (object)$waste;

            $wherearray = array(
                'id' => decryptId($waste->waste_code),
            );

            $existingDetails = $this->where($wherearray)->first();

            $quantity = $existingDetails->quantity - $waste->disposal_qty;
            $estimated_weight =  $existingDetails->estimated_weight - ($waste->disposal_qty * getpackageweight($existingDetails->type_of_packing));

            $update_array = array(
                'quantity' => $quantity,
                'estimated_weight' => $estimated_weight,
                'updated_by' => Auth::id()
            );
            $this->where('id', $existingDetails->id)->update($update_array);
        }
        return true;
    }




    protected static function booted()
    {
        static::addGlobalScope(new TrashScope('wastemanagement_waste_inventory'));
    }
}
