<?php

namespace App\Models\HIRADC;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


use App\Scopes\TrashScope;

class RiskStatus extends Model
{
    use  HasFactory;


    protected $table = 'hiradc_hiradc_status_log';
    protected $primaryKey = 'id';

    protected $fillable = [
        'risk_id',
        'risk_status',
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

    public function getlist($id){

        return $this->where('risk_id',$id)->get();
    }


    protected static function booted()
    {
        static::addGlobalScope(new TrashScope('hiradc_hiradc_status_log'));
    }
}
