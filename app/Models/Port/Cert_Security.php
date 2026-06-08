<?php

namespace App\Models\Port;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


use App\Scopes\TrashScope;

class Cert_Security extends Model
{
    use  HasFactory;


    protected $table = SECCERT;
    protected $primaryKey = 'id';
    protected $fillable = [
        'port_fk_id',
        'cert_name',
        'cert_file_name',
        'cert_path',
        'cert_ext',
        'cert_size',
        'cert_start_date',
        'cert_end_date',
        'cert_status',
        'status',
        'trash',
        'created_by',
        'updated_by',
    ];
    protected $attributes = [
        'status' => 1,
        'trash' => 'NO',
    ];

    public function list()
    {
        $request = request();
        $search = '';

        $query = $this->select('incident_master_category.*');



        $data_count = $query->count();
        $total_records = $data_count;

        $query->orderBy('id', 'DESC');


        if ($request->length != -1) {
            $query->offset($request->start)->limit($request->length);
        }

        $data = $query->get();

        $datas = [
            'data' => $data,
            'total_records' => $total_records
        ];

        return $datas;
    }

    public function store()
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

    public function exportdata()
    {
        $request = request();
        $search = '';

        $query = $this->select('incident_master_category.*');



        $query = $query->orderBy('id', 'Desc');
        return  $query->get();
    }

    public function selectcerticatedata($id)
    {

        $data = $this->select('*')
            ->where('port_fk_id', $id)
            ->get();

        return $data;
    }

    public function selectOneWhere($where)
    {

        $data = $this->select('*')
            ->where($where)
            ->first();

        return $data;
    }

    public function ajaxList()
    {

        $query = $this->select('id', 'category_name');

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

    public function getWhere()
    {

        $query = $this->select('id', 'category_name', 'input_type', 'required', 'other_params');

        $datas = $query->get();


        return $datas;
    }


    protected static function booted()
    {
        static::addGlobalScope(new TrashScope(SECCERT));
    }
}
