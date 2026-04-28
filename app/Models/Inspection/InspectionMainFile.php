<?php

namespace App\Models\Inspection;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Str;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;


use App\Scopes\TrashScope;

class InspectionMainFile extends Model
{
    use  HasFactory;


    protected $table = 'inspection_inspection_list_file';
    protected $primaryKey = 'id';

    protected $fillable = [
        'inspection_id',
        'type_id',
        'file_name',
        'file_orgname',
        'file_path',
        'file_size',
        'file_extension',
        'created_by',
        'status',
        'trash',
        'updated_by',
        'created_at',
        'updated_at'

    ];

    protected $attributes = [
        'status' => 1,
        'trash' => 'NO',
    ];


    public function store($inspection)
    {

        $request = request();

        $supporting_documents = $request->file('supporting_documents');

        if ($supporting_documents != null) {

            foreach ($supporting_documents as $key => $file) {

                    $uploadpath = 'public/uploads/inspection/supportingimage/' . $inspection->inspection_id;

                    $folderPath = public_path('uploads/inspection/supportingimage/' . $inspection->inspection_id);

                    if (!File::exists($folderPath)) {

                        File::makeDirectory($folderPath, 0755, true);
                    }

                    $filenewname = time() . Str::random('10') . '.' . $file->getClientOriginalExtension();

                    $fileName = $file->getClientOriginalName();
                    $fileSize = $file->getSize();

                    $fileExt = $file->getClientOriginalExtension();

                    $file->move($uploadpath, $filenewname);

                    $path = $uploadpath . "/" . $filenewname;
                    $user_id = Auth::id();

                    $insert_data = array(
                        'inspection_id' => $inspection->id,
                        'type_id' => 1,
                        'file_name' => $filenewname,
                        'file_orgname' => $fileName,
                        'file_path' => $path,
                        'file_size' => $fileSize,
                        'file_extension' => $fileExt,
                        'created_by' => $user_id,
                    );

                    $this->create($insert_data)->id;

            }
        }
    }

    public function getfiles($id, $type_id)
    {
        return $this->where('inspection_id', $id)->where('type_id', $type_id)->get();
    }

    public function getinspectionfiles($id)
    {
        return $this->where('inspection_id', $id)->get();
    }


    protected static function booted()
    {
        static::addGlobalScope(new TrashScope('inspection_inspection_list_file'));
    }
}
