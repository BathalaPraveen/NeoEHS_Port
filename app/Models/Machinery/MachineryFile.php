<?php

namespace App\Models\Machinery;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Str;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;


use App\Scopes\TrashScope;

class MachineryFile extends Model
{
    use  HasFactory;


    protected $table = 'machinery_upload_file';
    protected $primaryKey = 'id';

    protected $fillable = [
        'type',
        'machinery_id',
        'reference_id',
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


    public function store($machinery)
    {

        $request = request();

        $hazardDocument = $request->file('supportdocument');

        if ($hazardDocument != null) {

            foreach ($hazardDocument as $key => $ducument) {

                $uploadpath = 'public/uploads/machinery/' . $machinery->machinery_id;

                $folderPath = public_path('uploads/machinery/' . $machinery->machinery_id);

                if (!File::exists($folderPath)) {

                    File::makeDirectory($folderPath, 0755, true);
                }

                $filenewname = time() . Str::random('10') . '.' . $ducument->getClientOriginalExtension();

                $fileName = $ducument->getClientOriginalName();
                $fileSize = $ducument->getSize();

                $fileExt = $ducument->getClientOriginalExtension();

                $ducument->move($uploadpath, $filenewname);

                $path = $uploadpath . "/" . $filenewname;
                $user_id = Auth::id();

                $insert_data = array(
                    'type' => 1,
                    'machinery_id' => $machinery->id,
                    'reference_id' => decryptId($key),
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

    public function inspection($machinery)
    {

        $request = request();

        $ducument = $request->file('inspectionchecklist');

        if ($ducument != null) {

            $uploadpath = 'public/uploads/machinery/' . $machinery->machinery_id;

            $folderPath = public_path('uploads/machinery/' . $machinery->machinery_id);

            if (!File::exists($folderPath)) {

                File::makeDirectory($folderPath, 0755, true);
            }

            $filenewname = time() . Str::random('10') . '.' . $ducument->getClientOriginalExtension();

            $fileName = $ducument->getClientOriginalName();
            $fileSize = $ducument->getSize();

            $fileExt = $ducument->getClientOriginalExtension();

            $ducument->move($uploadpath, $filenewname);

            $path = $uploadpath . "/" . $filenewname;
            $user_id = Auth::id();

            $insert_data = array(
                'type' => 2,
                'machinery_id' => $machinery->id,
                'reference_id' => $machinery->id,
                'file_name' => $filenewname,
                'file_orgname' => $fileName,
                'file_path' => $path,
                'file_size' => $fileSize,
                'file_extension' => $fileExt,
                'created_by' => $user_id,
            );

            return $this->create($insert_data)->id;
        } else {
            return null;
        }
    }

    public function updates($machinery)
    {

        $request = request();

        $hazardDocument = $request->file('supportdocument');

        if ($hazardDocument != null) {

            foreach ($hazardDocument as $key => $ducument) {

                $uploadpath = 'public/uploads/machinery/' . $machinery->machinery_id;

                $folderPath = public_path('uploads/machinery/' . $machinery->machinery_id);

                if (!File::exists($folderPath)) {

                    File::makeDirectory($folderPath, 0755, true);
                }

                $filenewname = time() . Str::random('10') . '.' . $ducument->getClientOriginalExtension();

                $fileName = $ducument->getClientOriginalName();
                $fileSize = $ducument->getSize();

                $fileExt = $ducument->getClientOriginalExtension();

                $ducument->move($uploadpath, $filenewname);

                $path = $uploadpath . "/" . $filenewname;
                $user_id = Auth::id();

                $checkexist = array(
                    'type' => 1,
                    'machinery_id' => $machinery->id,
                    'reference_id' => decryptId($key),
                );

                $existdata =   $this->where($checkexist)->first();



                if ($existdata != null && $existdata != '') {

                    $update_array = array(
                        'status' => 0,
                        'trash' => 'YES'
                    );
                    $this->where('id', $existdata->id)->update($update_array);
                }


                $insert_data = array(
                    'type' => 1,
                    'machinery_id' => $machinery->id,
                    'reference_id' => decryptId($key),
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



    public function getWhere($Where)
    {

        return $this->where($Where)->get()->keyBy('reference_id')->toArray();
    }

    public function getWhereInspection($Where)
    {

        return $this->where($Where)->get()->keyBy('id')->toArray();
    }


    protected static function booted()
    {
        static::addGlobalScope(new TrashScope('machinery_upload_file'));
    }
}
