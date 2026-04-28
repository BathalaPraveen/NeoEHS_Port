<?php

namespace App\Models\PTW;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


use App\Scopes\TrashScope;

class HazardCategory extends Model
{
    use  HasFactory;


    protected $table = 'ptw_master_hazard_category';
    protected $primaryKey = 'id';

    protected $fillable = [
        'category_name',
        'subpermit',
    ];

    protected $attributes = [
        'status' => 1,
        'trash' => 'NO',
    ];



    protected static function booted()
    {
        static::addGlobalScope(new TrashScope('ptw_master_hazard_category'));
    }
}
