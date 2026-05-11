<?php

namespace App\Models\HIRADC;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


use App\Scopes\TrashScope;

class DocumentType extends Model
{
    use  HasFactory;


    protected $table = 'hiradc_master_document_type';
    protected $primaryKey = 'id';

    protected $fillable = [
        'document_id',
        'documenttype_name',
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

    public function list()
    {
        $request = request();
        $search = '';

        $query = $this->select('hiradc_master_document_type.*','hiradc_master_document.document_name');
        $query = $query->leftJoin('hiradc_master_document','hiradc_master_document_type.document_id' , '=' ,'hiradc_master_document.id');


       

        $data_count = $query->count();
        $total_records = $data_count;

        $query->orderBy('id','DESC');


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
            'document_id' => decryptId($request->document),
            'documenttype_name' => $request->documenttype_name,
            'created_by' => Auth::id()
        );

        return $this->create($insert_array);
    }

    public function updates($id)
    {

        $request = request();

        $update_array = array(
            'document_id' => decryptId($request->document),
            'documenttype_name' => $request->documenttype_name,
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

        $query = $this->select('hiradc_master_document_type.*','hiradc_master_document.document_name');
        $query = $query->leftJoin('hiradc_master_document','hiradc_master_document_type.document_id' , '=' ,'hiradc_master_document.id');

    
        $query = $query->orderBy('id', 'Desc');
        return  $query->get();
    }

        public function selectOne($id)
    {

        $data = $this->select('*')
            ->where('id', $id)
            ->first();

        return $data;
    }

    public function selectOneWhere($where)
    {

        $data = $this->select('*')
            ->where($where)
            ->first();

        return $data;
    }

    public function dataList($id = ''){

        $query = $this->select('id','documenttype_name');

        if($id != ''){
            $query = $query->where('document_id',$id);
        }

        $datas = $query->get();

        $list = [];
        foreach($datas as $data){
            $listvalue = [];
            $listvalue['id'] = encryptId($data->id);
            $listvalue['name'] = $data->documenttype_name;

            $list[] = $listvalue;
        }
        return $list;

    }

    public function getWhere($id = ''){

        $query = $this->select('id','documenttype_name');

        if($id != ''){
            $query = $query->where('document_id',$id);
        }

        $datas = $query->get();


        return $datas;

    }


    protected static function booted()
    {
        static::addGlobalScope(new TrashScope('hiradc_master_document_type'));


    }
}
