<?php

namespace App\Models\Chemical;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


use App\Scopes\TrashScope;

class ChemicalStatus extends Model
{
    use  HasFactory;


    protected $table = 'chemical_chemical_status';
    protected $primaryKey = 'id';

    protected $fillable = [
        'chemical_status',
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
        static::addGlobalScope(new TrashScope('chemical_chemical_status'));
    }
}
