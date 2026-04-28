<?php

namespace App\Models\PTW;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reassign extends Model
{
    use HasFactory;

    protected $table = 'ptw_reassign';
    protected $primaryKey = 'id';

    protected $fillable = [
        'ptw_id',
        'type',
        'assign_to',
        'from_assigned_person',
        'reassign_remarks',
        'created_by',
        'updated_by',
        'status',
        'trash',
        'created_at',
        'updated_at'

    ];

    protected $attributes = [
        'status' => 1,
        'trash' => 'NO',
    ];

    public function store($id,$type,$from_assign_person,$assign_to,$reassign_remarks)
    {
        $insert_array = array(
            'ptw_id' => $id,
            'type' => $type,
            'from_assigned_person' => $from_assign_person,
            'assign_to' => $assign_to,
            'reassign_remarks' => $reassign_remarks,
            'created_by' => Auth::id()
        );

        $this->create($insert_array);

        return true;
    }

    public function getLog($ptwId){
        $data = $this->where('ptw_id',$ptwId)->get();
        return $data;
    }
}
