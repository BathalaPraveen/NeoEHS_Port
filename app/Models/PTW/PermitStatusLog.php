<?php

namespace App\Models\PTW;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


use App\Scopes\TrashScope;

class PermitStatusLog extends Model
{
    use  HasFactory;


    protected $table = 'ptw_status_log';
    protected $primaryKey = 'id';

    protected $fillable = [
        'status_name',
        'permit_type',
        'ptw_id',
        'sub_permit_id',
        'from_status',
        'to_status',
        'is_reject',
        'remarks',
        'approved_by',
        'status',
        'trash',
        'created_at',
        'updated_at'

    ];

    protected $attributes = [
        'status' => 1,
        'trash' => 'NO',
    ];

    public function getDetails($permit_type,$ptw_id,$sub_permit_id){

        $whereArray = array(
            'permit_type' => $permit_type,
            'ptw_id' => $ptw_id,
            'sub_permit_id' => $sub_permit_id,
        );
        return $this->where($whereArray)->get();

    }

    protected static function booted()
    {
        static::addGlobalScope(new TrashScope('ptw_status_log'));
    }
}
