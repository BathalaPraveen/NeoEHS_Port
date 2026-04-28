<?php

namespace App\Models\Incident;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


use App\Scopes\TrashScope;

class NotificationStatusLog extends Model
{
    use  HasFactory;


    protected $table = 'incident_notification_status_log';
    protected $primaryKey = 'id';

    protected $fillable = [
        'incident_id',
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

    public function getDetails($incident_id){

        $whereArray = array(
            'incident_id' => $incident_id,
        );
        return $this->where($whereArray)->get();

    }

    protected static function booted()
    {
        static::addGlobalScope(new TrashScope('incident_notification_status_log'));
    }
}
