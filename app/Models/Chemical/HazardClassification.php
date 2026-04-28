<?php

namespace App\Models\Chemical;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


use App\Scopes\TrashScope;

class HazardClassification extends Model
{
    use  HasFactory;


    protected $table = 'chemical_master_hazard_classification';
    protected $primaryKey = 'id';

    protected $fillable = [
        'classification_code',
        'hazard_classification',
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
        static::addGlobalScope(new TrashScope('chemical_master_hazard_classification'));
    }
}
