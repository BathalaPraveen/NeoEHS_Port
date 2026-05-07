<?php

namespace App\Models\WasteManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


use App\Scopes\TrashScope;

class WasteCard extends Model
{
    use  HasFactory;


    protected $table = 'wastemanagement_waste_waste_card';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'company_id',
        'company',
        'waste_code',
        'origin',
        'flash_point',
        'boiling_point',
        'form_in_room_temp',
        'solubility_in_water',
        'density',
        'color',
        'odour',
        'risk',
        'ppe',
        'packaging_type',
        'grouping_on_pallet',
        'stacking_allowed',
        'pictogram_for_labelling',
        'recommended_method_of_disposal',
        'precautions',
        'material_damages',
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
            'wastemanagement_waste_waste_card.*',
            'wastemanagement_master_wastetype.wastetype_id',
            'wastemanagement_master_wastetype.wastetype_name',

        )
            ->join('wastemanagement_master_wastetype', 'wastemanagement_master_wastetype.id', '=', 'wastemanagement_waste_waste_card.waste_code');
        $companyid = getCompanyId($request->company);
        $query->where('wastemanagement_waste_waste_card.company_id', $companyid);

      

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
            'company' => decryptId($request->company),
            'waste_code' => decryptId($request->waste_code),
            'origin' => $request->origin,
            'flash_point' => $request->flash_point,
            'boiling_point' => $request->boiling_point,
            'form_in_room_temp' => decryptId($request->form_in_room_temp),
            'solubility_in_water' => decryptId($request->solubility_in_water),
            'density' => decryptId($request->density),
            'color' => $request->color,
            'odour' => $request->odour,
            'risk' => array_to_string(arrayDecrypt($request->risk)),
            'ppe' => array_to_string(arrayDecrypt($request->ppe)),
            'packaging_type' => decryptId($request->packaging_type),
            'grouping_on_pallet' => $request->grouping_on_pallet,
            'stacking_allowed' => $request->stacking_allowed,
            'pictogram_for_labelling' => $request->pictogram_for_labelling,
            'recommended_method_of_disposal' => decryptId($request->recommended_method_of_disposal),
            'precautions' => json_encode($request->per_inju),
            'material_damages' => json_encode($request->metedamage),
            'created_by' => Auth::id()
        );

        return $this->create($insert_array);
    }

    public function updates($id)
    {

        $request = request();

        $update_array = array(
            'company_id' => getCompanyId($request->companyname),
            'company' => decryptId($request->company),
            'waste_code' => decryptId($request->waste_code),
            'origin' => $request->origin,
            'flash_point' => $request->flash_point,
            'boiling_point' => $request->boiling_point,
            'form_in_room_temp' => decryptId($request->form_in_room_temp),
            'solubility_in_water' => decryptId($request->solubility_in_water),
            'density' => decryptId($request->density),
            'color' => $request->color,
            'odour' => $request->odour,
            'risk' => array_to_string(arrayDecrypt($request->risk)),
            'ppe' => array_to_string(arrayDecrypt($request->ppe)),
            'packaging_type' => decryptId($request->packaging_type),
            'grouping_on_pallet' => $request->grouping_on_pallet,
            'stacking_allowed' => $request->stacking_allowed,
            'pictogram_for_labelling' => $request->pictogram_for_labelling,
            'recommended_method_of_disposal' => decryptId($request->recommended_method_of_disposal),
            'precautions' => json_encode($request->per_inju),
            'material_damages' => json_encode($request->metedamage),
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

        $query = $this->select(
            'wastemanagement_waste_waste_card.*',
            'wastemanagement_master_wastetype.wastetype_id',
            'wastemanagement_master_wastetype.wastetype_name',

        )
            ->join('wastemanagement_master_wastetype', 'wastemanagement_master_wastetype.id', '=', 'wastemanagement_waste_waste_card.waste_code');

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
        static::addGlobalScope(new TrashScope('wastemanagement_waste_waste_card'));
    }
}
