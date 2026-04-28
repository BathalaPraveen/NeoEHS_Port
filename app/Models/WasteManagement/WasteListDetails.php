<?php

namespace App\Models\WasteManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


use App\Scopes\TrashScope;

class WasteListDetails extends Model
{
    use  HasFactory;


    protected $table = 'wastemanagement_waste_list_details';
    protected $primaryKey = 'id';

    protected $fillable = [
        'waste_list_id',
        'waste_type',
        'waste_type_id',
        'previous_record',
        'disposal_date',
        'total_disposal',
        'disposal_type',
        'balance_waste',
        'balance_waste_disposal_type',
        'new_generated_record',
        'total_balance_waste',
        'total_balance_waste_type',
        'weight',
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


    public function store($listId)
    {

        $request = request();



        $wasteDetails = $request->waste;

        foreach($wasteDetails as $waste){


            $current  = $waste['current'][1];
            $afterdisposal  = $waste['afterdisposal'][1];
            $balance  = $waste['balance'][1];

            $insert_array = array(
                'waste_list_id' => $listId,
                'waste_type' => decryptId($waste['wastetype']),
                'waste_type_id' => $waste['wastetypeid'],
                'previous_record' => json_encode($waste['previous']),
                'disposal_date' => DBdateformat($current['date']),
                'total_disposal' => $current['qty'],
                'disposal_type' => $current['uom'],
                'balance_waste' => $afterdisposal['qty'],
                'balance_waste_disposal_type' => $afterdisposal['uom'],
                'new_generated_record' => json_encode($waste['future']),
                'total_balance_waste' => $balance['qty'],
                'total_balance_waste_type' => $balance['uom'],
                'weight' => $waste['weight'],
                'created_by' => Auth::id()
            );

            $this->create($insert_array);
        }

        return true;
    }

    public function updates($id)
    {

        $request = request();

        $trashArray = array(
            'trash' => 'YES',
            'status' => 0,
        );

        $this->where('waste_list_id', $id)->update($trashArray);

        $wasteDetails = $request->waste;

        foreach($wasteDetails as $waste){


            $current  = $waste['current'][1];
            $afterdisposal  = $waste['afterdisposal'][1];
            $balance  = $waste['balance'][1];

            $insert_array = array(
                'waste_list_id' => $id,
                'waste_type' => decryptId($waste['wastetype']),
                'waste_type_id' => $waste['wastetypeid'],
                'previous_record' => json_encode($waste['previous']),
                'disposal_date' => DBdateformat($current['date']),
                'total_disposal' => $current['qty'],
                'disposal_type' => $current['uom'],
                'balance_waste' => $afterdisposal['qty'],
                'balance_waste_disposal_type' => $afterdisposal['uom'],
                'new_generated_record' => json_encode($waste['future']),
                'total_balance_waste' => $balance['qty'],
                'total_balance_waste_type' => $balance['uom'],
                'weight' => $waste['weight'],
                'created_by' => Auth::id()
            );

            $this->create($insert_array);
        }


    }

    public function getwhere($where)
    {

        $data = $this->select('wastemanagement_waste_list_details.*','wastemanagement_master_wastetype.wastetype_id','wastemanagement_master_wastetype.wastetype_name')
            ->leftJoin('wastemanagement_master_wastetype', 'wastemanagement_waste_list_details.waste_type', '=', 'wastemanagement_master_wastetype.id')
            ->where($where)
            ->get();

        return $data;
    }

    protected static function booted()
    {
        static::addGlobalScope(new TrashScope('wastemanagement_waste_list_details'));
    }
}
