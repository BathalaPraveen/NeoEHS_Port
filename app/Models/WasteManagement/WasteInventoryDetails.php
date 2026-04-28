<?php

namespace App\Models\WasteManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


use App\Scopes\TrashScope;

use App\Models\WasteManagement\WasteInventory;

class WasteInventoryDetails extends Model
{
    use  HasFactory;


    protected $table = 'wastemanagement_waste_inventory_details';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'company_id',
        'inventory_type',
        'waste_code',
        'generation_date',
        'location',
        'quantity',
        'type_of_packing',
        'estimated_weight',
        'entry_date',
        'entry_qty',
        'current_qty',
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
            'wastemanagement_waste_inventory_details.*',
            'wastemanagement_master_wastetype.wastetype_id',
            'wastemanagement_master_wastetype.wastetype_name',
        )
            ->join('wastemanagement_master_wastetype', 'wastemanagement_master_wastetype.id', '=', 'wastemanagement_waste_inventory_details.waste_code');

        $companyid = getCompanyId($request->company);
        $query->where('wastemanagement_waste_inventory_details.company_id', $companyid);

        if ($request->has('wastetype') && $request->wastetype != null) {
            $query->where('wastemanagement_waste_inventory_details.waste_code', decryptId($request->wastetype));
        }

        if ($request->search['value'] != null || $request->search['value'] != '') {
            $search = $request->search['value'];

            $query->where(function ($query) use ($search) {
                $query->orWhere('wastemanagement_master_wastetype.wastetype_id', 'LIKE', '%' . $search . '%');
                $query->orWhere('wastemanagement_master_wastetype.wastetype_name', 'LIKE', '%' . $search . '%');
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


    public function addlist()
    {
        $request = request();
        $search = '';

        $query = $this->select(
            'wastemanagement_waste_inventory_details.*',
            'wastemanagement_master_wastetype.wastetype_id',
            'wastemanagement_master_wastetype.wastetype_name',
        )
            ->join('wastemanagement_master_wastetype', 'wastemanagement_master_wastetype.id', '=', 'wastemanagement_waste_inventory_details.waste_code');

        $companyid = getCompanyId($request->company);
        $query->where('wastemanagement_waste_inventory_details.company_id', $companyid);
        $query->where('wastemanagement_waste_inventory_details.inventory_type', INVENTORY_ADD);

        if ($request->has('wastetype') && $request->wastetype != null) {
            $query->where('wastemanagement_waste_inventory_details.waste_code', decryptId($request->wastetype));
        }

        if ($request->search['value'] != null || $request->search['value'] != '') {
            $search = $request->search['value'];

            $query->where(function ($query) use ($search) {
                $query->orWhere('wastemanagement_master_wastetype.wastetype_id', 'LIKE', '%' . $search . '%');
                $query->orWhere('wastemanagement_master_wastetype.wastetype_name', 'LIKE', '%' . $search . '%');
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

    public function disposallist()
    {
        $request = request();
        $search = '';

        $query = $this->select(
            'wastemanagement_waste_inventory_details.*',
            'wastemanagement_master_wastetype.wastetype_id',
            'wastemanagement_master_wastetype.wastetype_name',
        )
            ->join('wastemanagement_master_wastetype', 'wastemanagement_master_wastetype.id', '=', 'wastemanagement_waste_inventory_details.waste_code');

        $companyid = getCompanyId($request->company);
        $query->where('wastemanagement_waste_inventory_details.company_id', $companyid);
        $query->where('wastemanagement_waste_inventory_details.inventory_type', INVENTORY_DISPOSAL);

        if ($request->has('wastetype') && $request->wastetype != null) {
            $query->where('wastemanagement_waste_inventory_details.waste_code', decryptId($request->wastetype));
        }

        if ($request->search['value'] != null || $request->search['value'] != '') {
            $search = $request->search['value'];

            $query->where(function ($query) use ($search) {
                $query->orWhere('wastemanagement_master_wastetype.wastetype_id', 'LIKE', '%' . $search . '%');
                $query->orWhere('wastemanagement_master_wastetype.wastetype_name', 'LIKE', '%' . $search . '%');
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
        $currentqty = 0;

        $wastedetails = $request->wasteadd;

        foreach ($wastedetails as $waste) {
            $waste = (object)$waste;

            $insert_array = array(
                'company_id' => getCompanyId($request->companyname),
                'inventory_type' => 1,
                'waste_code' => decryptId($waste->waste_code),
                'generation_date' => DBdateformat($waste->generation_date),
                'location' => decryptId($waste->location),
                'quantity' => $waste->quantity,
                'type_of_packing' => decryptId($waste->type_of_packaging),
                'estimated_weight' => $waste->estimated_weight,
                'entry_date' => todayDbdate(),
                'entry_qty' => $waste->quantity,
                'current_qty' => $currentqty,
                'created_by' => Auth::id()
            );

            $this->create($insert_array);
        }



        return true;
    }

    public function disposalstore()
    {

        $request = request();

        $wastelistdetails = $request->wastesdisposal;

        foreach ($wastelistdetails as $waste) {

            $waste = (object)$waste;

            $wherearray = array(
                'id' => decryptId($waste->waste_code),
            );

            $existingDetails = WasteInventory::where($wherearray)->first();

            $currentqty = $waste->quantity -  $waste->disposal_qty;

            $insert_array = array(
                'company_id' => getCompanyId($request->companyname),
                'inventory_type' => 2,
                'waste_code' => $existingDetails->waste_code,
                'generation_date' => $existingDetails->generation_date,
                'location' => $existingDetails->location,
                'quantity' => $waste->quantity,
                'type_of_packing' => $existingDetails->type_of_packing,
                'estimated_weight' => $waste->estimated_weight,
                'entry_date' => todayDbdate(),
                'entry_qty' => $waste->disposal_qty,
                'current_qty' => $currentqty,
                'created_by' => Auth::id()
            );

            $this->create($insert_array);
        }

        return true;
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
        $search = '';

        $query = $this->select('wastemanagement_waste_inventory_details.*');

        if ($request->search != null || $request->search != '') {
            $search = $request->search;

            $query->where(function ($query) use ($search) {
                $query->orWhere('wastemanagement_waste_inventory_details.wastetype_id', 'LIKE', '%' . $search . '%');
                $query->orWhere('wastemanagement_waste_inventory_details.wastetype_name', 'LIKE', '%' . $search . '%');
            });
        }

        $query = $query->orderBy('id', 'Desc');
        return  $query->get();
    }

    public function exportdataadd()
    {
        $request = request();
        $search = '';

        $query = $this->select(
            'wastemanagement_waste_inventory_details.*',
            'wastemanagement_master_wastetype.wastetype_id',
            'wastemanagement_master_wastetype.wastetype_name',
        )
            ->join('wastemanagement_master_wastetype', 'wastemanagement_master_wastetype.id', '=', 'wastemanagement_waste_inventory_details.waste_code');

        $companyid = getCompanyId($request->company);
        $query->where('wastemanagement_waste_inventory_details.company_id', $companyid);
        $query->where('wastemanagement_waste_inventory_details.inventory_type', INVENTORY_ADD);

        if ($request->has('wastetype') && $request->wastetype != null) {
            $query->where('wastemanagement_waste_inventory_details.waste_code', decryptId($request->wastetype));
        }
        $query = $query->orderBy('wastemanagement_waste_inventory_details.id', 'Desc');
        return  $query->get();
    }

    public function exportdatadisposal()
    {
        $request = request();
        $search = '';

        $query = $this->select(
            'wastemanagement_waste_inventory_details.*',
            'wastemanagement_master_wastetype.wastetype_id',
            'wastemanagement_master_wastetype.wastetype_name',
        )
            ->join('wastemanagement_master_wastetype', 'wastemanagement_master_wastetype.id', '=', 'wastemanagement_waste_inventory_details.waste_code');

        $companyid = getCompanyId($request->company);
        $query->where('wastemanagement_waste_inventory_details.company_id', $companyid);
        $query->where('wastemanagement_waste_inventory_details.inventory_type', INVENTORY_DISPOSAL);

        if ($request->has('wastetype') && $request->wastetype != null) {
            $query->where('wastemanagement_waste_inventory_details.waste_code', decryptId($request->wastetype));
        }

        $query = $query->orderBy('wastemanagement_waste_inventory_details.id', 'Desc');
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

    public function getWhere($activity = '')
    {

        $query = $this->select('id', 'wastetype_name', 'input_type', 'required', 'other_params');

        if ($activity != '') {
            $query = $query->where('wastetype_id', $activity);
        }

        $datas = $query->get();


        return $datas;
    }

    protected static function booted()
    {
        static::addGlobalScope(new TrashScope('wastemanagement_waste_inventory_details'));
    }
}
