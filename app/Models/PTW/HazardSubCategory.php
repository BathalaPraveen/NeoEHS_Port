<?php

namespace App\Models\PTW;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


use App\Scopes\TrashScope;

class HazardSubCategory extends Model
{
    use  HasFactory;


    protected $table = 'ptw_master_hazard_subcategory';
    protected $primaryKey = 'id';

    protected $fillable = [
        'subpermit',
        'category_id',
        'subcategory_name',
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


    public function ajaxList($categoryId, $subpermit)
    {

        $datas = $this->select('ptw_master_hazard_subcategory.*')
            ->where('category_id', $categoryId)
            ->get();

        $list = [];
        foreach ($datas as $data) {
            $listvalue = [];
            $listvalue['id'] = encryptId($data->id);
            $listvalue['name'] = $data->subcategory_name;
            $list[] = $listvalue;
        }

        $listvalue = [];
        $listvalue['id'] = 0;
        $listvalue['name'] = 'Others';
        $list[] = $listvalue;
        return $list;
    }


    protected static function booted()
    {
        static::addGlobalScope(new TrashScope('ptw_master_hazard_subcategory'));
    }
}
