<?php

namespace App\Models\PTW;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


use App\Scopes\TrashScope;

class SubpermitStatus extends Model
{
    use  HasFactory;


    protected $table = 'ptw_sub_permit_status';
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
        static::addGlobalScope(new TrashScope('ptw_sub_permit_status'));
    }
}
