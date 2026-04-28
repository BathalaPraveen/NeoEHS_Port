<?php

namespace App\Models\Machinery;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


use App\Scopes\TrashScope;

class MachineryStatus extends Model
{
    use  HasFactory;


    protected $table = 'machinery_machinery_status';
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
        static::addGlobalScope(new TrashScope('machinery_machinery_status'));
    }
}
