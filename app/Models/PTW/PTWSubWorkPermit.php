<?php

namespace App\Models\PTW;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


use App\Scopes\TrashScope;

class PTWSubWorkPermit extends Model
{
    use  HasFactory;


    protected $table = 'ptw_master_subwork_permit';
    protected $primaryKey = 'id';

    protected $fillable = [
        'permit_name',
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
        static::addGlobalScope(new TrashScope('ptw_master_subwork_permit'));

    }
}
