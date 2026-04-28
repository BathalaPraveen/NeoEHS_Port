<?php

namespace App\Models\ATAR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Str;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;


use App\Scopes\TrashScope;

class UAUCFile extends Model
{
    use  HasFactory;


    protected $table = 'atar_uauc_file';
    protected $primaryKey = 'id';

    protected $fillable = [
        'atar_id',
        'file_type',
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


    public function store($uauc)
    {

        $request = request();

        $useeimagefiles = $request->file('useeimage');
        $uactimagefiles = $request->file('uactimage');
        $finaldocumentfiles = $request->file('finalimage');
        $hscdocumentfiles = $request->file('hscImage');

        if ($useeimagefiles != null) {

            foreach ($useeimagefiles as $useeimage) {


                $uploadpath = 'public/uploads/atar/uauc/' . $uauc->atar_id;

                $folderPath = public_path('uploads/atar/uauc/' . $uauc->atar_id);

                if (!File::exists($folderPath)) {

                    File::makeDirectory($folderPath, 0755, true);
                }

                $filenewname = time() . Str::random('10') . '.' . $useeimage->getClientOriginalExtension();

                $fileName = $useeimage->getClientOriginalName();
                $fileSize = $useeimage->getSize();

                $fileExt = $useeimage->getClientOriginalExtension();

                $useeimage->move($uploadpath, $filenewname);

                $path = $uploadpath . "/" . $filenewname;
                $user_id = Auth::id();

                $insert_data = array(
                    'atar_id' => $uauc->id,
                    'file_type' => 1,
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

        if ($uactimagefiles != null) {

            foreach ($uactimagefiles as $uactimage) {


                $uploadpath = 'public/uploads/atar/uauc/' . $uauc->atar_id;

                $folderPath = public_path('uploads/atar/uauc/' . $uauc->atar_id);

                if (!File::exists($folderPath)) {

                    File::makeDirectory($folderPath, 0755, true);
                }

                $filenewname = time() . Str::random('10') . '.' . $uactimage->getClientOriginalExtension();

                $fileName = $uactimage->getClientOriginalName();
                $fileSize = $uactimage->getSize();

                $fileExt = $uactimage->getClientOriginalExtension();

                $uactimage->move($uploadpath, $filenewname);

                $path = $uploadpath . "/" . $filenewname;
                $user_id = Auth::id();

                $insert_data = array(
                    'atar_id' => $uauc->id,
                    'file_type' => 2,
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

        if ($finaldocumentfiles != null) {

            foreach ($finaldocumentfiles as $finaldocument) {

                $uploadpath = 'public/uploads/atar/uauc/' . $uauc->atar_id;

                $folderPath = public_path('uploads/atar/uauc/' . $uauc->atar_id);

                if (!File::exists($folderPath)) {

                    File::makeDirectory($folderPath, 0755, true);
                }

                $filenewname = time() . Str::random('10') . '.' . $finaldocument->getClientOriginalExtension();

                $fileName = $finaldocument->getClientOriginalName();
                $fileSize = $finaldocument->getSize();

                $fileExt = $finaldocument->getClientOriginalExtension();

                $finaldocument->move($uploadpath, $filenewname);

                $path = $uploadpath . "/" . $filenewname;
                $user_id = Auth::id();

                $insert_data = array(
                    'atar_id' => $uauc->id,
                    'file_type' => 3,
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

        if ($hscdocumentfiles != null) {

            foreach ($hscdocumentfiles as $hscdocument) {

                $uploadpath = 'public/uploads/atar/uauc/' . $uauc->atar_id;

                $folderPath = public_path('uploads/atar/uauc/' . $uauc->atar_id);

                if (!File::exists($folderPath)) {

                    File::makeDirectory($folderPath, 0755, true);
                }

                $filenewname = time() . Str::random('10') . '.' . $hscdocument->getClientOriginalExtension();

                $fileName = $hscdocument->getClientOriginalName();
                $fileSize = $hscdocument->getSize();

                $fileExt = $hscdocument->getClientOriginalExtension();

                $hscdocument->move($uploadpath, $filenewname);

                $path = $uploadpath . "/" . $filenewname;
                $user_id = Auth::id();

                $insert_data = array(
                    'atar_id' => $uauc->id,
                    'file_type' => 4,
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

    public function imageupload($uauc)
    {

        $request = request();

        $useeimagefiles = $request->useeimage;

        if ($useeimagefiles != null) {

            foreach ($useeimagefiles as $uactimage) {


                $base64Image = $uactimage;
                $data = preg_replace('#^data:[a-z]+/[a-z0-9-]+;base64,#i', '', $base64Image);
                $decodedImage = base64_decode($data);

                $finfo = finfo_open();
                $mimeType = finfo_buffer($finfo, $decodedImage, FILEINFO_MIME_TYPE);
                finfo_close($finfo);

                $validFormats = [
                    'image/jpeg',
                    'image/jpg',
                    'image/png',
                    'video/mp4'
                ];

                if (!in_array($mimeType, $validFormats)) {
                    // Handle invalid format (e.g., return an error response)
                }

                $mimetypes = array(
                    'image/jpeg' => 'jpeg',
                    'image/jpg' => 'jpg',
                    'image/png' => 'png',
                    'video/mp4' => 'mp4'
                );

                $extension = $mimetypes[$mimeType];

                $path = 'uploads/atar/uauc/' . $uauc->atar_id;

                $folderPath = public_path('uploads/atar/uauc/' . $uauc->atar_id);

                if (!File::exists($folderPath)) {

                    File::makeDirectory($folderPath, 0755, true);
                }

                $filenewname = time() . Str::random('10') . '.' .  $extension;
                $uploadpath = $path . "/" . $filenewname;
                $publicuploadpath = "public/" . $uploadpath;
                Storage::disk('upload')->put($uploadpath, $decodedImage);

                $fileSize = filesize(public_path($uploadpath));

                $user_id = Auth::id();

                $insert_data = array(
                    'atar_id' => $uauc->id,
                    'file_type' => 1,
                    'file_name' => $filenewname,
                    'file_orgname' => $filenewname,
                    'file_path' => $publicuploadpath,
                    'file_size' => $fileSize,
                    'file_extension' => $extension,
                    'created_by' => $user_id,
                );

                $this->create($insert_data)->id;
            }
        }

        $uactimagefiles = $request->uactimage;

        if ($uactimagefiles != null) {
            foreach ($uactimagefiles as $fileData) {

                $data = preg_replace('#^data:[a-z]+/[a-z0-9-]+;base64,#i', '', $fileData);
                $decodedFile = base64_decode($data);

                $finfo = finfo_open();
                $mimeType = finfo_buffer($finfo, $decodedFile, FILEINFO_MIME_TYPE);
                finfo_close($finfo);

                $validFormats = [
                    'image/jpeg' => 'jpeg',
                    'image/jpg' => 'jpg',
                    'image/png' => 'png',
                    'video/mp4' => 'mp4'
                ];

                if (!array_key_exists($mimeType, $validFormats)) {
                    return response()->json(['error' => 'Invalid file format.'], 400);
                }

                $extension = $validFormats[$mimeType];

                $path = 'uploads/atar/uauc/' . $uauc->atar_id;
                $folderPath = public_path($path);

                if (!File::exists($folderPath)) {
                    File::makeDirectory($folderPath, 0755, true);
                }

                $filenewname = time() . Str::random(10) . '.' . $extension;
                $uploadpath = $path . "/" . $filenewname;
                $publicuploadpath = "public/" . $uploadpath;

                Storage::disk('upload')->put($uploadpath, $decodedFile);

                $fileSize = filesize(public_path($uploadpath));

                $user_id = Auth::id();

                $insert_data = [
                    'atar_id' => $uauc->id,
                    'file_type' => 2,
                    'file_name' => $filenewname,
                    'file_orgname' => $filenewname,
                    'file_path' => $publicuploadpath,
                    'file_size' => $fileSize,
                    'file_extension' => $extension,
                    'created_by' => $user_id,
                ];


                $test =  $this->create($insert_data)->id;
            }
        }


        $finalimage = $request->closetimage;

        if ($finalimage != null && count($finalimage) > 0) {

            foreach ($finalimage as $final) {


                $base64Image = $final;
                $data = preg_replace('#^data:[a-z]+/[a-z0-9-]+;base64,#i', '', $base64Image);
                $decodedImage = base64_decode($data);

                $finfo = finfo_open();
                $mimeType = finfo_buffer($finfo, $decodedImage, FILEINFO_MIME_TYPE);
                finfo_close($finfo);

                $validFormats = [
                    'image/jpeg',
                    'image/jpg',
                    'image/png',
                    'video/mp4'
                ];

                if (!in_array($mimeType, $validFormats)) {
                    // Handle invalid format (e.g., return an error response)
                }

                $mimetypes = array(
                    'image/jpeg' => 'jpeg',
                    'image/jpg' => 'jpg',
                    'image/png' => 'png',
                    'video/mp4' => 'mp4'
                );

                $extension = $mimetypes[$mimeType];

                $path = 'uploads/atar/uauc/' . $uauc->atar_id;

                $folderPath = public_path('uploads/atar/uauc/' . $uauc->atar_id);

                if (!File::exists($folderPath)) {

                    File::makeDirectory($folderPath, 0755, true);
                }

                $filenewname = time() . Str::random('10') . '.' .  $extension;
                $uploadpath = $path . "/" . $filenewname;
                $publicuploadpath = "public/" . $uploadpath;
                Storage::disk('upload')->put($uploadpath, $decodedImage);

                $fileSize = filesize(public_path($uploadpath));

                $user_id = Auth::id();

                $insert_data = array(
                    'atar_id' => $uauc->id,
                    'file_type' => 3,
                    'file_name' => $filenewname,
                    'file_orgname' => $filenewname,
                    'file_path' => $publicuploadpath,
                    'file_size' => $fileSize,
                    'file_extension' => $extension,
                    'created_by' => $user_id,
                );

                $this->create($insert_data)->id;
            }
        }

        $hscdocumentfiles = $request->hscImage;

        // dd($hscdocumentfiles);
        if ($hscdocumentfiles != null) {

            foreach ($hscdocumentfiles as $hscImage) {


                $base64Image = $hscImage;
                $data = preg_replace('#^data:[a-z]+/[a-z0-9-]+;base64,#i', '', $base64Image);
                $decodedImage = base64_decode($data);

                $finfo = finfo_open();
                $mimeType = finfo_buffer($finfo, $decodedImage, FILEINFO_MIME_TYPE);
                finfo_close($finfo);

                $validFormats = [
                    'image/jpeg',
                    'image/jpg',
                    'image/png', 
                    'video/mp4'
                ];

                if (!in_array($mimeType, $validFormats)) {
                    // Handle invalid format (e.g., return an error response)
                }

                $mimetypes = array(
                    'image/jpeg' => 'jpeg',
                    'image/jpg' => 'jpg',
                    'image/png' => 'png',
                    'video/mp4' => 'mp4'
                );

                $extension = $mimetypes[$mimeType];



                $path = 'uploads/atar/uauc/' . $uauc->atar_id;

                $folderPath = public_path('uploads/atar/uauc/' . $uauc->atar_id);

                if (!File::exists($folderPath)) {

                    File::makeDirectory($folderPath, 0755, true);
                }

                $filenewname = time() . Str::random('10') . '.' .  $extension;
                $uploadpath = $path . "/" . $filenewname;
                $publicuploadpath = "public/" . $uploadpath;
                Storage::disk('upload')->put($uploadpath, $decodedImage);

                $fileSize = filesize(public_path($uploadpath));

                $user_id = Auth::id();

                $insert_data = array(
                    'atar_id' => $uauc->id,
                    'file_type' => 4,
                    'file_name' => $filenewname,
                    'file_orgname' => $filenewname,
                    'file_path' => $publicuploadpath,
                    'file_size' => $fileSize,
                    'file_extension' => $extension,
                    'created_by' => $user_id,
                );

                $this->create($insert_data)->id;
            }
        }
    }


    public function getfiles($id, $type)
    {

        return $this->where('atar_id', $id)->where('file_type', $type)->get();
    }


    protected static function booted()
    {
        static::addGlobalScope(new TrashScope('atar_uauc_file'));
    }
}
