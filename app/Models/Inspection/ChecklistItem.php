<?php

namespace App\Models\Inspection;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


use App\Scopes\TrashScope;

class ChecklistItem extends Model
{
    use  HasFactory;


    protected $table = 'inspection_master_checklist_item';
    protected $primaryKey = 'id';

    protected $fillable = [
        'inspectiontype_id',
        'category_id',
        'item_name',
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

        $query = $this->select('inspection_master_checklist_item.*', 'inspection_master_inspection_type.inspectiontype_name', 'inspection_master_checklist_category.category_name');
        $query = $query->leftJoin('inspection_master_inspection_type', 'inspection_master_checklist_item.inspectiontype_id', '=', 'inspection_master_inspection_type.id');
        $query = $query->leftJoin('inspection_master_checklist_category', 'inspection_master_checklist_item.category_id', '=', 'inspection_master_checklist_category.id');


        if ($request->search['value'] != null || $request->search['value'] != '') {
            $search = $request->search['value'];

            $query->where(function ($query) use ($search) {

                $query->orWhere('inspection_master_checklist_item.item_name', 'LIKE', '%' . $search . '%');
                $query->orWhere('inspection_master_inspection_type.inspectiontype_name', 'LIKE', '%' . $search . '%');
                $query->orWhere('inspection_master_checklist_category.category_name', 'LIKE', '%' . $search . '%');
            });
        }

        $data_count = $query->count();
        $total_records = $data_count;

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

    public function store($category)
    {

        $request = request();

        $inspectiontypeId = $category->inspectiontype_id;
        $categoryId = $category->id;

        $itemlistdetails = $request->itemlist;

        foreach ($itemlistdetails as $item) {

            $insert_array = array(
                'inspectiontype_id' => $inspectiontypeId,
                'category_id' => $categoryId,
                'item_name' => $item,
                'created_by' => Auth::id()
            );

            $this->create($insert_array);
        }



        return true;
    }


    public function storesingle($category)
    {

        $request = request();

        $inspectiontypeId = $category->inspectiontype_id;
        $categoryId = $category->id;

        $item = $request->item_name;

        $insert_array = array(
            'inspectiontype_id' => $inspectiontypeId,
            'category_id' => $categoryId,
            'item_name' => $item,
            'created_by' => Auth::id()
        );

        $this->create($insert_array);

        return true;
    }

    public function updates($category)
    {

        $request = request();

        $inspectiontypeId = $category->inspectiontype_id;
        $categoryId = $category->id;

        $itemlistdetails = $request->itemlist;

        $trashupdate = array(
            'status' => 0,
            'trash' => 'YES'
        );
        $this->where('category_id', $categoryId)->update($trashupdate);

        foreach ($itemlistdetails as $itemdetails) {

            $item = $itemdetails['item'];

            if (isset($itemdetails['id'])) {

                $id = decryptId($itemdetails['id']);

                $update_array = array(
                    'inspectiontype_id' => $inspectiontypeId,
                    'category_id' => $categoryId,
                    'item_name' => $item,
                    'status' => 1,
                    'trash' => 'NO',
                    'updated_by' => Auth::id()
                );
                $this->withoutGlobalScope(TrashScope::class)->where('id', $id)->update($update_array);
            } else {
                $insert_array = array(
                    'inspectiontype_id' => $inspectiontypeId,
                    'category_id' => $categoryId,
                    'item_name' => $item,
                    'created_by' => Auth::id()
                );

                $this->create($insert_array);
            }
        }

        return true;
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

        $query = $this->select('inspection_master_checklist_item.*', 'inspection_master_inspection_type.inspectiontype_name', 'inspection_master_checklist_category.category_name');
        $query = $query->leftJoin('inspection_master_inspection_type', 'inspection_master_checklist_item.inspectiontype_id', '=', 'inspection_master_inspection_type.id');
        $query = $query->leftJoin('inspection_master_checklist_category', 'inspection_master_checklist_item.category_id', '=', 'inspection_master_checklist_category.id');


        if ($request->search != null || $request->search != '') {
            $search = $request->search;

            $query->where(function ($query) use ($search) {

                $query->orWhere('inspection_master_checklist_item.item_name', 'LIKE', '%' . $search . '%');
                $query->orWhere('inspection_master_inspection_type.inspectiontype_name', 'LIKE', '%' . $search . '%');
                $query->orWhere('inspection_master_checklist_category.category_name', 'LIKE', '%' . $search . '%');
            });
        }


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

    public function getWhere($where)
    {

        $query = $this->select('id', 'item_name');

        if ($where != '') {
            $query = $query->where($where);
        }

        $datas = $query->get();


        return $datas;
    }


    public function CategoryItem($inspectiontype)
    {

        $query = $this->select('id', 'inspectiontype_id', 'category_id', 'item_name');

        if ($inspectiontype != '') {
            $query = $query->where('inspectiontype_id', $inspectiontype);
        }

        $datas = $query->get();

        if ($datas != null && $datas != '') {

            $itemlist = [];
            foreach ($datas as $loan) {

                $itemlist[$loan->category_id][] = $loan;
            }
        }


        return $itemlist;
    }



    protected static function booted()
    {
        static::addGlobalScope(new TrashScope('inspection_master_checklist_item'));
    }
}
