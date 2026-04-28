<?php

namespace App\Models\Inspection;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


use App\Scopes\TrashScope;

class InspectionStatus extends Model
{
    use  HasFactory;


    protected $table = 'inspection_inspection_status';
    protected $primaryKey = 'id';

    protected $fillable = [
        'status_name',
        'bg_color',
        'status',
        'trash',
        'created_at',
        'updated_at'

    ];

    protected $attributes = [
        'status' => 1,
        'trash' => 'NO',
    ];


    protected static function booted()
    {
        static::addGlobalScope(new TrashScope('inspection_inspection_status'));
    }
}
