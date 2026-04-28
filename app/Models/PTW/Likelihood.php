<?php

namespace App\Models\PTW;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


use App\Scopes\TrashScope;

class Likelihood extends Model
{
    use  HasFactory;


    protected $table = 'ptw_master_likelihood';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'example',
        'rating',
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
        static::addGlobalScope(new TrashScope('ptw_master_likelihood'));
    }
}
