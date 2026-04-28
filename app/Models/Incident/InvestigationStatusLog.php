<?php

namespace App\Models\Incident;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


use App\Scopes\TrashScope;

class InvestigationStatusLog extends Model
{
    use  HasFactory;


    protected $table = 'incident_investigation_status_log';
    protected $primaryKey = 'id';

    protected $fillable = [
        'investigation_id',
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

    public function getDetails($investigation_id){

        $whereArray = array(
            'investigation_id' => $investigation_id,
        );
        return $this->where($whereArray)->get();

    }

    protected static function booted()
    {
        static::addGlobalScope(new TrashScope('incident_investigation_status_log'));
    }
}
