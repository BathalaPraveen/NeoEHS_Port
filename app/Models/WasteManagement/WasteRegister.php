<?php

namespace App\Models\WasteManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


use App\Scopes\TrashScope;

class WasteRegister extends Model
{
    use  HasFactory;


    protected $table = 'wastemanagement_waste_register';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'company_id',
        'waste_code',
        'waste_form',
        'notification_date',
        'notification_no',
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

        $companyid = getCompanyId($request->company);

        $query = $this->select(
            'wastemanagement_waste_register.*',
            'wastemanagement_master_wastetype.wastetype_id',
            'wastemanagement_master_wastetype.wastetype_name',
            'wastemanagement_master_item.item_name as wasteform',
        )
            ->join('wastemanagement_master_wastetype', 'wastemanagement_master_wastetype.id', '=', 'wastemanagement_waste_register.waste_code')
            ->join('wastemanagement_master_item', 'wastemanagement_master_item.id', '=', 'wastemanagement_waste_register.waste_form');

        $query->where('wastemanagement_waste_register.company_id', $companyid);

        if($request->wastetype != ''){
            $query->where('wastemanagement_waste_register.waste_code', decryptId($request->wastetype));
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
            'company_id' => getCompanyId($request->companyname),
            'waste_code' => decryptId($request->waste_code),
            'waste_form' => decryptId($request->waste_form),
            'notification_date' => DBdateformat($request->notification_date),
            'notification_no' => $request->notification_no,
            'created_by' => Auth::id()
        );

        return $this->create($insert_array);
    }

    public function updates($id)
    {

        $request = request();

        $update_array = array(
            'company_id' => getCompanyId($request->companyname),
            'waste_code' => decryptId($request->waste_code),
            'waste_form' => decryptId($request->waste_form),
            'notification_date' => DBdateformat($request->notification_date),
            'notification_no' => $request->notification_no,
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

        $companyid = getCompanyId($request->company);

        $result =$this -> select(
            'wastemanagement_waste_register.*',
            'wastemanagement_master_wastetype.wastetype_id',
            'wastemanagement_master_wastetype.wastetype_name',
            'wastemanagement_master_item.item_name'
        )
        ->join('wastemanagement_master_wastetype', 'wastemanagement_master_wastetype.id', '=', 'wastemanagement_waste_register.waste_code')
        ->join('wastemanagement_master_item', 'wastemanagement_master_item.id', '=', 'wastemanagement_waste_register.waste_form')
        ->where('wastemanagement_waste_register.trash', 'NO')
        ->get();

        // $result = $result->orderBy('id', 'Desc');
        return  $result;
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
        static::addGlobalScope(new TrashScope('wastemanagement_waste_register'));
    }
}
