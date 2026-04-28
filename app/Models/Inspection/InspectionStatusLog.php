<?php

namespace App\Models\Inspection;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


use App\Scopes\TrashScope;

class InspectionStatusLog extends Model
{
    use  HasFactory;


    protected $table = 'inspection_inspection_status_log';
    protected $primaryKey = 'id';

    protected $fillable = [
        'inspection_id',
        'from_status',
        'to_status',
        'remarks',
        'created_by',
        'status',
        'trash',
        'created_at',
        'updated_at'

    ];

    protected $attributes = [
        'status' => 1,
        'trash' => 'NO',
    ];

    public function getDetails($inspection_id){

        $whereArray = array(
            'inspection_id' => $inspection_id,
        );
        return $this->where($whereArray)->get();

    }

    protected static function booted()
    {
        static::addGlobalScope(new TrashScope('inspection_inspection_status_log'));
    }
}
