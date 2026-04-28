<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

use App\Scopes\TrashScope;

class Announcement extends Model
{
    use  HasFactory;


    protected $table = 'master_announcement';
    protected $primaryKey = 'id';

    protected $fillable = [
        'announcement_id',
        'announcement_title',
        'announcement_content',
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

        if ($request->search['value'] != null || $request->search['value'] != '') {
            $search = $request->search['value'];

            $query->where(function ($query) use ($search) {
                $query->orWhere('announcement_id', 'LIKE', '%' . $search . '%')
                    ->orWhere('announcement_title', 'LIKE', '%' . $search . '%')
                    ->orWhere('announcement_content', 'LIKE', '%' . $search . '%');
            });
        }

        $data_count = $query->count();
        $total_records = $data_count;

        $query->orderBy('id','ASC');


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

            'announcement_title' => $request->announcement_title,
            'announcement_content' => $request->announcement_content,
            'created_by' => Auth::id()
        );

        return $this->create($insert_array);
    }

    public function updates($id)
    {

        $request = request();

        $update_array = array(
            'announcement_title' => $request->announcement_title,
            'announcement_content' => $request->announcement_content,
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

        if ($request->search != null || $request->search != '') {
            $search = $request->search;

            $query->where(function ($query) use ($search) {
                $query->orWhere('announcement_id', 'LIKE', '%' . $search . '%')
                    ->orWhere('announcement_title', 'LIKE', '%' . $search . '%')
                    ->orWhere('announcement_content', 'LIKE', '%' . $search . '%');
            });
        }

        $query = $query->orderBy('created_at', 'Desc');
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


    public static function booted()
    {
        static::addGlobalScope(new TrashScope('master_announcement'));

        static::created(function ($model) {

            $uniqueId = 'ANMT-' . str_pad($model->id, 5, '0', STR_PAD_LEFT);
            $model->update(['announcement_id' => $uniqueId]);
        });
    }
}
