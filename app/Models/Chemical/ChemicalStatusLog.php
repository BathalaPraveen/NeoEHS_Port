<?php

namespace App\Models\Chemical;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


use App\Scopes\TrashScope;

class ChemicalStatusLog extends Model
{
    use  HasFactory;

    protected $table = 'chemical_chemical_status_log';
    protected $primaryKey = 'id';

    protected $fillable = [
        'chemical_id',
        'from_status',
        'to_status',
        'status_description',
        'created_by',
        'status',
        'trash',
        'created_at',
        'updated_at'

    ];

    protected $attributes = [
        'status' => 1,
        'trash' => 'NO',
    ];

    public function getDetails($inspection_id){

        $whereArray = array(
            'waste_id' => $inspection_id,
        );
        return $this->where($whereArray)->get();

    }

    protected static function booted()
    {
        static::addGlobalScope(new TrashScope('chemical_chemical_status_log'));
    }
}
