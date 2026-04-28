<?php

namespace App\Models\WasteManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


use App\Scopes\TrashScope;

class WasteStatusLog extends Model
{
    use  HasFactory;

    protected $table = 'wastemanagement_waste_status_log';
    protected $primaryKey = 'id';

    protected $fillable = [
        'waste_id',
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
            'waste_id' => $inspection_id,
        );
        return $this->where($whereArray)->get();

    }

    protected static function booted()
    {
        static::addGlobalScope(new TrashScope('wastemanagement_waste_status_log'));
    }
}
