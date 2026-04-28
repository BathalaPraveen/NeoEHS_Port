<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

use App\Models\Master\Location;
use App\Scopes\TrashScope;

class EmployeeCategory extends Model
{
    use  HasFactory;


    protected $table = 'master_employee_category';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'category_name',
        'status',
        'trash',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'

    ];

    protected $attributes = [
        'status' => 1,
        'trash' => 'NO',
    ];


    public function UniqueCheck($data)
    {
        return $this->where($data['param'],  $data['value'])->get();
    }

    public function ExistuniqueCheck($data)
    {
        return $this->where($data['param'],  $data['value'])
            ->where('id', '!=', decryptId($data['id']))
            ->get();
    }

    public function store($id)
    {

        $request = request();

        $insert_array = array(
            'category_name' => $request->category_name,
            'created_by' => Auth::id()
        );

        return $this->create($insert_array);
    }

    public function updates($id)
    {

        $request = request();

        $update_array = array(
            'category_name' => $request->category_name,
            'updated_by' => Auth::id()
        );

        return $this->where('id', $id)->update($update_array);
    }

    public function statuschange($id)
    {
        $request = request();

        $type = $request->types;
        if ($type == 1) {
            $update_data = array(
                'status' => 0,
            );
        } else {
            $update_data = array(
                'status' => 1,
            );
        }

        return $this->where('id', $id)->update($update_data);
    }

    public function deleterecord($id)
    {

        $update_data = array(
            'status' => 0,
            'trash' => 'YES',
        );

        return $this->where('id', $id)->update($update_data);
    }


    public function ajaxList($where, $whereIn = [])
    {

        $query = $this->select('id', 'category_name');

        if (count($where) > 0) {
            $query = $query->where($where);
        }

        $datas = $query->get();

        $list = [];
        foreach ($datas as $data) {
            $listvalue = [];
            $listvalue['id'] = encryptId($data->id);
            $listvalue['name'] = $data->category_name;

            $list[] = $listvalue;
        }

        return $list;
    }

    protected static function booted()
    {
        static::addGlobalScope(new TrashScope('master_employee_category'));
    }
}
