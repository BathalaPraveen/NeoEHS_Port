<?php

namespace App\Models\Machinery;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


use App\Scopes\TrashScope;

class MachineryStatusLog extends Model
{
    use  HasFactory;


    protected $table = 'machinery_status_log';
    protected $primaryKey = 'id';

    protected $fillable = [
        'status_name',
        'machinery_id',
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

    public function getDetails($id)
    {
        $whereArray = array(
            'machinery_id' => $id,
        );

        return $this->where($whereArray)->get();
    }

    protected static function booted()
    {
        static::addGlobalScope(new TrashScope('machinery_status_log'));
    }
}
