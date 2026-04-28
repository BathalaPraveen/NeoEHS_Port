<?php

namespace App\Models\PTW;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Str;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;


use App\Scopes\TrashScope;

class PTWFile extends Model
{
    use  HasFactory;


    protected $table = 'ptw_upload_file';
    protected $primaryKey = 'id';

    protected $fillable = [
        'ptw_id',
        'ptw_module',
        'file_type',
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


    public function general($ptw)
    {


        $request = request();

        $hazardDocument = $request->file('hazard_document_file');

        if ($hazardDocument != null) {

            foreach ($hazardDocument as $key => $ducument) {

                $uploadpath = 'public/uploads/ptw/general/' . $ptw->ptw_id;

                $folderPath = public_path('uploads/ptw/general/' . $ptw->ptw_id);

                if (!File::exists($folderPath)) {

                    File::makeDirectory($folderPath, 0755, true);
                }

                $filenewname = time() . Str::random('20') . '.' . $ducument->getClientOriginalExtension();

                $fileName = $ducument->getClientOriginalName();
                $fileSize = $ducument->getSize();

                $fileExt = $ducument->getClientOriginalExtension();

                $ducument->move($uploadpath, $filenewname);

                $path = $uploadpath . "/" . $filenewname;
                $user_id = Auth::id();

                $insert_data = array(
                    'ptw_id' => $ptw->id,
                    'ptw_module' => 0,
                    'file_type' => 1,
                    'reference_id' => $key,
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

        $supportDocument = $request->file('supporting_documents_file');

        if ($supportDocument != null) {

            foreach ($supportDocument as $key => $ducument) {

                $uploadpath = 'public/uploads/ptw/general/' . $ptw->ptw_id;

                $folderPath = public_path('uploads/ptw/general/' . $ptw->ptw_id);

                if (!File::exists($folderPath)) {

                    File::makeDirectory($folderPath, 0755, true);
                }

                $filenewname = time() . Str::random('20') . '.' . $ducument->getClientOriginalExtension();

                $fileName = $ducument->getClientOriginalName();
                $fileSize = $ducument->getSize();

                $fileExt = $ducument->getClientOriginalExtension();

                $ducument->move($uploadpath, $filenewname);

                $path = $uploadpath . "/" . $filenewname;
                $user_id = Auth::id();

                $insert_data = array(
                    'ptw_id' => $ptw->id,
                    'ptw_module' => 0,
                    'file_type' => 2,
                    'reference_id' => $key,
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

    public function generalUpdate($ptw)
    {


        $request = request();

        $hazardDocument = $request->file('hazard_document_file');

        if ($hazardDocument != null) {

            foreach ($hazardDocument as $key => $ducument) {

                $uploadpath = 'public/uploads/ptw/general/' . $ptw->ptw_id;

                $folderPath = public_path('uploads/ptw/general/' . $ptw->ptw_id);

                if (!File::exists($folderPath)) {

                    File::makeDirectory($folderPath, 0755, true);
                }

                $filenewname = time() . Str::random('20') . '.' . $ducument->getClientOriginalExtension();

                $fileName = $ducument->getClientOriginalName();
                $fileSize = $ducument->getSize();

                $fileExt = $ducument->getClientOriginalExtension();

                $ducument->move($uploadpath, $filenewname);

                $path = $uploadpath . "/" . $filenewname;
                $user_id = Auth::id();

                $updateArray = array(
                    'ptw_id' => $ptw->id,
                    'ptw_module' => 0,
                    'file_type' => 1,
                    'reference_id' => $key,
                );

                $this->where($updateArray)->update(['trash' => 'YES']);

                $updateArray = array(
                    'ptw_id' => $ptw->id,
                    'ptw_module' => 0,
                    'file_type' => 1,
                );

                $hazarddocuments = arrayDecrypt($request->supportcertificate);

                $this->whereNotIn('reference_id',$hazarddocuments)->where( $updateArray )->update(['trash' => 'YES']);


                $insert_data = array(
                    'ptw_id' => $ptw->id,
                    'ptw_module' => 0,
                    'file_type' => 1,
                    'reference_id' => $key,
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

        $supportDocument = $request->file('supporting_documents_file');

        if ($supportDocument != null) {

            foreach ($supportDocument as $key => $ducument) {

                $uploadpath = 'public/uploads/ptw/general/' . $ptw->ptw_id;

                $folderPath = public_path('uploads/ptw/general/' . $ptw->ptw_id);

                if (!File::exists($folderPath)) {

                    File::makeDirectory($folderPath, 0755, true);
                }

                $filenewname = time() . Str::random('20') . '.' . $ducument->getClientOriginalExtension();

                $fileName = $ducument->getClientOriginalName();
                $fileSize = $ducument->getSize();

                $fileExt = $ducument->getClientOriginalExtension();

                $ducument->move($uploadpath, $filenewname);

                $path = $uploadpath . "/" . $filenewname;
                $user_id = Auth::id();

                $updateArray = array(
                    'ptw_id' => $ptw->id,
                    'ptw_module' => 0,
                    'file_type' => 2,
                    'reference_id' => $key,
                );

                $this->where($updateArray)->update(['trash' => 'YES','status' => 0]);

                $updateArray = array(
                    'ptw_id' => $ptw->id,
                    'ptw_module' => 0,
                    'file_type' => 2,
                );
                $supportdocument = arrayDecrypt($request->supportcertificate);

                $this->whereNotIn('reference_id',$supportdocument)->where( $updateArray )->update(['trash' => 'YES']);

                $insert_data = array(
                    'ptw_id' => $ptw->id,
                    'ptw_module' => 0,
                    'file_type' => 2,
                    'reference_id' => $key,
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


    public function traffic($ptw)
    {

        $request = request();

        $ducument = $request->file('uploadplan');


        if ($ducument != null) {

                $uploadpath = 'public/uploads/ptw/traffic/' . $ptw->ptw_id;

                $folderPath = public_path('uploads/ptw/traffic/' . $ptw->ptw_id);

                if (!File::exists($folderPath)) {

                    File::makeDirectory($folderPath, 0755, true);
                }

                $filenewname = time() . Str::random('20') . '.' . $ducument->getClientOriginalExtension();

                $fileName = $ducument->getClientOriginalName();
                $fileSize = $ducument->getSize();

                $fileExt = $ducument->getClientOriginalExtension();

                $ducument->move($uploadpath, $filenewname);

                $path = $uploadpath . "/" . $filenewname;
                $user_id = Auth::id();

                $insert_data = array(
                    'ptw_id' => $ptw->ptw_id,
                    'ptw_module' => 5,
                    'file_type' => 3,
                    'reference_id' =>  $ptw->id,
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

    public function trafficUpdate($ptw)
    {


        $request = request();

        $ducument = $request->file('uploadplan');

        if ($ducument != null) {

                $uploadpath = 'public/uploads/ptw/traffic/' . $ptw->ptw_id;

                $folderPath = public_path('uploads/ptw/traffic/' . $ptw->ptw_id);

                if (!File::exists($folderPath)) {

                    File::makeDirectory($folderPath, 0755, true);
                }

                $filenewname = time() . Str::random('20') . '.' . $ducument->getClientOriginalExtension();

                $fileName = $ducument->getClientOriginalName();
                $fileSize = $ducument->getSize();

                $fileExt = $ducument->getClientOriginalExtension();

                $ducument->move($uploadpath, $filenewname);

                $path = $uploadpath . "/" . $filenewname;
                $user_id = Auth::id();


                $whereArray = array(
                    'ptw_id' => $ptw->ptw_id,
                    'ptw_module' => 5,
                    'file_type' => 3,
                    'reference_id' =>  $ptw->id,
                );
                $this->where($whereArray)->update(['trash' => 'YES']);

                $insert_data = array(
                    'ptw_id' => $ptw->ptw_id,
                    'ptw_module' => 5,
                    'file_type' => 3,
                    'reference_id' =>  $ptw->id,
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

    public function lifting($ptw)
    {

        $request = request();


        $ducument = $request->file('liftingsupervisor_document');

        if ($ducument != null) {

                $uploadpath = 'public/uploads/ptw/lifting/' . $ptw->ptw_id;

                $folderPath = public_path('uploads/ptw/lifting/' . $ptw->ptw_id);

                if (!File::exists($folderPath)) {

                    File::makeDirectory($folderPath, 0755, true);
                }

                $filenewname = time() . Str::random('20') . '.' . $ducument->getClientOriginalExtension();

                $fileName = $ducument->getClientOriginalName();
                $fileSize = $ducument->getSize();

                $fileExt = $ducument->getClientOriginalExtension();

                $ducument->move($uploadpath, $filenewname);

                $path = $uploadpath . "/" . $filenewname;
                $user_id = Auth::id();

                $insert_data = array(
                    'ptw_id' => $ptw->ptw_id,
                    'ptw_module' => 6,
                    'file_type' => 1,
                    'reference_id' =>  $ptw->id,
                    'file_name' => $filenewname,
                    'file_orgname' => $fileName,
                    'file_path' => $path,
                    'file_size' => $fileSize,
                    'file_extension' => $fileExt,
                    'created_by' => $user_id,
                );

                $this->create($insert_data)->id;

        }

        $ducument = $request->file('liftingcraneoperator_document');

        if ($ducument != null) {

                $uploadpath = 'public/uploads/ptw/lifting/' . $ptw->ptw_id;

                $folderPath = public_path('uploads/ptw/lifting/' . $ptw->ptw_id);

                if (!File::exists($folderPath)) {

                    File::makeDirectory($folderPath, 0755, true);
                }

                $filenewname = time() . Str::random('20') . '.' . $ducument->getClientOriginalExtension();

                $fileName = $ducument->getClientOriginalName();
                $fileSize = $ducument->getSize();

                $fileExt = $ducument->getClientOriginalExtension();

                $ducument->move($uploadpath, $filenewname);

                $path = $uploadpath . "/" . $filenewname;
                $user_id = Auth::id();

                $insert_data = array(
                    'ptw_id' => $ptw->ptw_id,
                    'ptw_module' => 6,
                    'file_type' => 2,
                    'reference_id' =>  $ptw->id,
                    'file_name' => $filenewname,
                    'file_orgname' => $fileName,
                    'file_path' => $path,
                    'file_size' => $fileSize,
                    'file_extension' => $fileExt,
                    'created_by' => $user_id,
                );

                $this->create($insert_data)->id;

        }

        $ducument = $request->file('liftingsignalman_document');

        if ($ducument != null) {

                $uploadpath = 'public/uploads/ptw/lifting/' . $ptw->ptw_id;

                $folderPath = public_path('uploads/ptw/lifting/' . $ptw->ptw_id);

                if (!File::exists($folderPath)) {

                    File::makeDirectory($folderPath, 0755, true);
                }

                $filenewname = time() . Str::random('20') . '.' . $ducument->getClientOriginalExtension();

                $fileName = $ducument->getClientOriginalName();
                $fileSize = $ducument->getSize();

                $fileExt = $ducument->getClientOriginalExtension();

                $ducument->move($uploadpath, $filenewname);

                $path = $uploadpath . "/" . $filenewname;
                $user_id = Auth::id();

                $insert_data = array(
                    'ptw_id' => $ptw->ptw_id,
                    'ptw_module' => 6,
                    'file_type' => 3,
                    'reference_id' =>  $ptw->id,
                    'file_name' => $filenewname,
                    'file_orgname' => $fileName,
                    'file_path' => $path,
                    'file_size' => $fileSize,
                    'file_extension' => $fileExt,
                    'created_by' => $user_id,
                );

                $this->create($insert_data)->id;

        }

        $ducument = $request->file('liftingrigger_document');

        if ($ducument != null) {

                $uploadpath = 'public/uploads/ptw/lifting/' . $ptw->ptw_id;

                $folderPath = public_path('uploads/ptw/lifting/' . $ptw->ptw_id);

                if (!File::exists($folderPath)) {

                    File::makeDirectory($folderPath, 0755, true);
                }

                $filenewname = time() . Str::random('20') . '.' . $ducument->getClientOriginalExtension();

                $fileName = $ducument->getClientOriginalName();
                $fileSize = $ducument->getSize();

                $fileExt = $ducument->getClientOriginalExtension();

                $ducument->move($uploadpath, $filenewname);

                $path = $uploadpath . "/" . $filenewname;
                $user_id = Auth::id();

                $insert_data = array(
                    'ptw_id' => $ptw->ptw_id,
                    'ptw_module' => 6,
                    'file_type' => 4,
                    'reference_id' =>  $ptw->id,
                    'file_name' => $filenewname,
                    'file_orgname' => $fileName,
                    'file_path' => $path,
                    'file_size' => $fileSize,
                    'file_extension' => $fileExt,
                    'created_by' => $user_id,
                );

                $this->create($insert_data)->id;

        }

        $ducument = $request->file('liftingothers_document');

        if ($ducument != null) {

                $uploadpath = 'public/uploads/ptw/lifting/' . $ptw->ptw_id;

                $folderPath = public_path('uploads/ptw/lifting/' . $ptw->ptw_id);

                if (!File::exists($folderPath)) {

                    File::makeDirectory($folderPath, 0755, true);
                }

                $filenewname = time() . Str::random('20') . '.' . $ducument->getClientOriginalExtension();

                $fileName = $ducument->getClientOriginalName();
                $fileSize = $ducument->getSize();

                $fileExt = $ducument->getClientOriginalExtension();

                $ducument->move($uploadpath, $filenewname);

                $path = $uploadpath . "/" . $filenewname;
                $user_id = Auth::id();

                $insert_data = array(
                    'ptw_id' => $ptw->ptw_id,
                    'ptw_module' => 6,
                    'file_type' => 5,
                    'reference_id' =>  $ptw->id,
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

    public function liftingUpdate($ptw)
    {


        $request = request();

        $ducument = $request->file('liftingsupervisor_document');

        if ($ducument != null) {

                $uploadpath = 'public/uploads/ptw/lifting/' . $ptw->ptw_id;

                $folderPath = public_path('uploads/ptw/lifting/' . $ptw->ptw_id);

                if (!File::exists($folderPath)) {

                    File::makeDirectory($folderPath, 0755, true);
                }

                $filenewname = time() . Str::random('20') . '.' . $ducument->getClientOriginalExtension();

                $fileName = $ducument->getClientOriginalName();
                $fileSize = $ducument->getSize();

                $fileExt = $ducument->getClientOriginalExtension();

                $ducument->move($uploadpath, $filenewname);

                $path = $uploadpath . "/" . $filenewname;
                $user_id = Auth::id();


                $whereArray = array(
                    'ptw_id' => $ptw->ptw_id,
                    'ptw_module' => 6,
                    'file_type' => 1,
                    'reference_id' =>  $ptw->id,
                );
                $this->where($whereArray)->update(['trash' => 'YES']);

                $insert_data = array(
                    'ptw_id' => $ptw->ptw_id,
                    'ptw_module' => 6,
                    'file_type' => 1,
                    'reference_id' =>  $ptw->id,
                    'file_name' => $filenewname,
                    'file_orgname' => $fileName,
                    'file_path' => $path,
                    'file_size' => $fileSize,
                    'file_extension' => $fileExt,
                    'created_by' => $user_id,
                );

                $this->create($insert_data)->id;

        }

        $ducument = $request->file('liftingcraneoperator_document');

        if ($ducument != null) {

                $uploadpath = 'public/uploads/ptw/lifting/' . $ptw->ptw_id;

                $folderPath = public_path('uploads/ptw/lifting/' . $ptw->ptw_id);

                if (!File::exists($folderPath)) {

                    File::makeDirectory($folderPath, 0755, true);
                }

                $filenewname = time() . Str::random('20') . '.' . $ducument->getClientOriginalExtension();

                $fileName = $ducument->getClientOriginalName();
                $fileSize = $ducument->getSize();

                $fileExt = $ducument->getClientOriginalExtension();

                $ducument->move($uploadpath, $filenewname);

                $path = $uploadpath . "/" . $filenewname;
                $user_id = Auth::id();


                $whereArray = array(
                    'ptw_id' => $ptw->ptw_id,
                    'ptw_module' => 6,
                    'file_type' => 2,
                    'reference_id' =>  $ptw->id,
                );
                $this->where($whereArray)->update(['trash' => 'YES']);

                $insert_data = array(
                    'ptw_id' => $ptw->ptw_id,
                    'ptw_module' => 6,
                    'file_type' => 2,
                    'reference_id' =>  $ptw->id,
                    'file_name' => $filenewname,
                    'file_orgname' => $fileName,
                    'file_path' => $path,
                    'file_size' => $fileSize,
                    'file_extension' => $fileExt,
                    'created_by' => $user_id,
                );

                $this->create($insert_data)->id;

        }

        $ducument = $request->file('liftingsignalman_document');

        if ($ducument != null) {

                $uploadpath = 'public/uploads/ptw/lifting/' . $ptw->ptw_id;

                $folderPath = public_path('uploads/ptw/lifting/' . $ptw->ptw_id);

                if (!File::exists($folderPath)) {

                    File::makeDirectory($folderPath, 0755, true);
                }

                $filenewname = time() . Str::random('20') . '.' . $ducument->getClientOriginalExtension();

                $fileName = $ducument->getClientOriginalName();
                $fileSize = $ducument->getSize();

                $fileExt = $ducument->getClientOriginalExtension();

                $ducument->move($uploadpath, $filenewname);

                $path = $uploadpath . "/" . $filenewname;
                $user_id = Auth::id();


                $whereArray = array(
                    'ptw_id' => $ptw->ptw_id,
                    'ptw_module' => 6,
                    'file_type' => 3,
                    'reference_id' =>  $ptw->id,
                );
                $this->where($whereArray)->update(['trash' => 'YES']);

                $insert_data = array(
                    'ptw_id' => $ptw->ptw_id,
                    'ptw_module' => 6,
                    'file_type' => 3,
                    'reference_id' =>  $ptw->id,
                    'file_name' => $filenewname,
                    'file_orgname' => $fileName,
                    'file_path' => $path,
                    'file_size' => $fileSize,
                    'file_extension' => $fileExt,
                    'created_by' => $user_id,
                );

                $this->create($insert_data)->id;

        }

        $ducument = $request->file('liftingrigger_document');

        if ($ducument != null) {

                $uploadpath = 'public/uploads/ptw/lifting/' . $ptw->ptw_id;

                $folderPath = public_path('uploads/ptw/lifting/' . $ptw->ptw_id);

                if (!File::exists($folderPath)) {

                    File::makeDirectory($folderPath, 0755, true);
                }

                $filenewname = time() . Str::random('20') . '.' . $ducument->getClientOriginalExtension();

                $fileName = $ducument->getClientOriginalName();
                $fileSize = $ducument->getSize();

                $fileExt = $ducument->getClientOriginalExtension();

                $ducument->move($uploadpath, $filenewname);

                $path = $uploadpath . "/" . $filenewname;
                $user_id = Auth::id();


                $whereArray = array(
                    'ptw_id' => $ptw->ptw_id,
                    'ptw_module' => 6,
                    'file_type' => 4,
                    'reference_id' =>  $ptw->id,
                );
                $this->where($whereArray)->update(['trash' => 'YES']);

                $insert_data = array(
                    'ptw_id' => $ptw->ptw_id,
                    'ptw_module' => 6,
                    'file_type' => 4,
                    'reference_id' =>  $ptw->id,
                    'file_name' => $filenewname,
                    'file_orgname' => $fileName,
                    'file_path' => $path,
                    'file_size' => $fileSize,
                    'file_extension' => $fileExt,
                    'created_by' => $user_id,
                );

                $this->create($insert_data)->id;

        }

        $ducument = $request->file('liftingothers_document');

        if ($ducument != null) {

                $uploadpath = 'public/uploads/ptw/traffic/' . $ptw->ptw_id;

                $folderPath = public_path('uploads/ptw/traffic/' . $ptw->ptw_id);

                if (!File::exists($folderPath)) {

                    File::makeDirectory($folderPath, 0755, true);
                }

                $filenewname = time() . Str::random('20') . '.' . $ducument->getClientOriginalExtension();

                $fileName = $ducument->getClientOriginalName();
                $fileSize = $ducument->getSize();

                $fileExt = $ducument->getClientOriginalExtension();

                $ducument->move($uploadpath, $filenewname);

                $path = $uploadpath . "/" . $filenewname;
                $user_id = Auth::id();


                $whereArray = array(
                    'ptw_id' => $ptw->ptw_id,
                    'ptw_module' => 6,
                    'file_type' => 5,
                    'reference_id' =>  $ptw->id,
                );
                $this->where($whereArray)->update(['trash' => 'YES']);

                $insert_data = array(
                    'ptw_id' => $ptw->ptw_id,
                    'ptw_module' => 6,
                    'file_type' => 5,
                    'reference_id' =>  $ptw->id,
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




    public function getWhere($ptwWhere){

        return $this->where($ptwWhere)->get()->keyBy('reference_id')->toArray();
    }

    public function getWhererby($ptwWhere){

        return $this->where($ptwWhere)->get()->keyBy('file_type')->toArray();
    }

    protected static function booted()
    {
        static::addGlobalScope(new TrashScope('ptw_upload_file'));
    }
}
