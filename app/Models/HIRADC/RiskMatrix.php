<?php

namespace App\Models\HIRADC;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


use App\Scopes\TrashScope;

class RiskMatrix extends Model
{
    use  HasFactory;


    protected $table = 'ptw_master_risk_matrix';
    protected $primaryKey = 'id';

    protected $fillable = [
        'likelihood',
        'severity',
        'rating',
        'color_code',
        'created_by',
        'updated_by',
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
        static::addGlobalScope(new TrashScope('ptw_master_risk_matrix'));
    }
}
