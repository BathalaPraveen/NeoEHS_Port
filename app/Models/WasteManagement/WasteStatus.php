<?php

namespace App\Models\WasteManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


use App\Scopes\TrashScope;

class WasteStatus extends Model
{
    use  HasFactory;


    protected $table = 'wastemanagement_waste_status';
    protected $primaryKey = 'id';

    protected $fillable = [
        'waste_status',
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
        static::addGlobalScope(new TrashScope('wastemanagement_waste_status'));
    }
}
