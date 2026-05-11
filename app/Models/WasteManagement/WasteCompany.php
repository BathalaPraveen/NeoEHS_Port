<?php

namespace App\Models\WasteManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

use App\Scopes\TrashScope;
use Illuminate\Support\Facades\DB;

class WasteCompany extends Model
{
    use  HasFactory;


    protected $table = 'wastemanagement_master_company';
    protected $primaryKey = 'id';

    protected $fillable = [
        'company_name',
        'company_address',
        'person_incharge',
        'contact_no',
        'email',
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
        $query = $this->select('*');

       

        $query->orderBy('id', 'DESC');
        $data_count = $query;
        $total_records = $data_count->count();

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

            'company_name' => $request->company_name,
            'company_address' => $request->company_address,
            'person_incharge' => $request->person_incharge,
            'contact_no' => $request->contact_no,
            'email' => $request->email,
            'created_by' => Auth::id()
        );
        return $this->create($insert_array);
    }

    public function updates($id)
    {

        $request = request();

        $update_array = array(
            'company_name' => $request->company_name,
            'company_address' => $request->company_address,
            'person_incharge' => $request->person_incharge,
            'contact_no' => $request->contact_no,
            'email' => $request->email,
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

        $query = $this->select('*');

        

        $query = $query->orderBy('created_at', 'Desc');
        return  $query->get();
    }

    public function selectOne()
    {
        $request = request();
        $companyid = getCompanyId($request->company);
        $data = $this->select('*')
            ->where('id', $companyid)
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


    public static function booted()
    {
        static::addGlobalScope(new TrashScope('wastemanagement_master_company'));
    }
}
