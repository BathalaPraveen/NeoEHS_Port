<?php

namespace App\Models\Incident;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Str;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;


use App\Scopes\TrashScope;

class InvestigationFile extends Model
{
    use  HasFactory;


    protected $table = 'incident_investigation_files';
    protected $primaryKey = 'id';

    protected $fillable = [
        'investigation_id',
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


    public function store($investigation)
    {

        $request = request();

        $appendicies_files = $request->file('appendicies');
        $tripod_beta_report_files = $request->file('tripod_beta_report');
        $witness_statements_files = $request->file('witness_statements');
        $photo_videos_files = $request->file('photo_videos');
        $equipment_inspection_files = $request->file('equipment_inspection');
        $training_records_files = $request->file('training_records');
        $other_records_files = $request->file('other_records');


        if ($appendicies_files != null) {

            foreach ($appendicies_files as $appendicies) {

                $uploadpath = 'public/uploads/incident/investigation/' . $investigation->investigation_id;

                $folderPath = public_path('uploads/incident/investigation/' . $investigation->investigation_id);

                if (!File::exists($folderPath)) {

                    File::makeDirectory($folderPath, 0755, true);
                }

                $filenewname = time() . Str::random('10') . '.' . $appendicies->getClientOriginalExtension();

                $fileName = $appendicies->getClientOriginalName();
                $fileSize = $appendicies->getSize();

                $fileExt = $appendicies->getClientOriginalExtension();

                $appendicies->move($uploadpath, $filenewname);

                $path = $uploadpath . "/" . $filenewname;
                $user_id = Auth::id();

                $insert_data = array(
                    'investigation_id' => $investigation->id,
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

        if ($tripod_beta_report_files != null) {

            foreach ($tripod_beta_report_files as $tripod_beta_report) {

                $uploadpath = 'public/uploads/incident/investigation/' . $investigation->investigation_id;

                $folderPath = public_path('uploads/incident/investigation/' . $investigation->investigation_id);

                if (!File::exists($folderPath)) {

                    File::makeDirectory($folderPath, 0755, true);
                }

                $filenewname = time() . Str::random('10') . '.' . $tripod_beta_report->getClientOriginalExtension();

                $fileName = $tripod_beta_report->getClientOriginalName();
                $fileSize = $tripod_beta_report->getSize();

                $fileExt = $tripod_beta_report->getClientOriginalExtension();

                $tripod_beta_report->move($uploadpath, $filenewname);

                $path = $uploadpath . "/" . $filenewname;
                $user_id = Auth::id();

                $insert_data = array(
                    'investigation_id' => $investigation->id,
                    'type_id' => 2,
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

        if ($witness_statements_files != null) {

            foreach ($witness_statements_files as $witness_statements) {

                $uploadpath = 'public/uploads/incident/investigation/' . $investigation->investigation_id;

                $folderPath = public_path('uploads/incident/investigation/' . $investigation->investigation_id);

                if (!File::exists($folderPath)) {

                    File::makeDirectory($folderPath, 0755, true);
                }

                $filenewname = time() . Str::random('10') . '.' . $witness_statements->getClientOriginalExtension();

                $fileName = $witness_statements->getClientOriginalName();
                $fileSize = $witness_statements->getSize();

                $fileExt = $witness_statements->getClientOriginalExtension();

                $witness_statements->move($uploadpath, $filenewname);

                $path = $uploadpath . "/" . $filenewname;
                $user_id = Auth::id();

                $insert_data = array(
                    'investigation_id' => $investigation->id,
                    'type_id' => 3,
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

        if ($photo_videos_files != null) {

            foreach ($photo_videos_files as $photo_videos) {

                $uploadpath = 'public/uploads/incident/investigation/' . $investigation->investigation_id;

                $folderPath = public_path('uploads/incident/investigation/' . $investigation->investigation_id);

                if (!File::exists($folderPath)) {

                    File::makeDirectory($folderPath, 0755, true);
                }

                $filenewname = time() . Str::random('10') . '.' . $photo_videos->getClientOriginalExtension();

                $fileName = $photo_videos->getClientOriginalName();
                $fileSize = $photo_videos->getSize();

                $fileExt = $photo_videos->getClientOriginalExtension();

                $photo_videos->move($uploadpath, $filenewname);

                $path = $uploadpath . "/" . $filenewname;
                $user_id = Auth::id();

                $insert_data = array(
                    'investigation_id' => $investigation->id,
                    'type_id' => 4,
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

        if ($equipment_inspection_files != null) {

            foreach ($equipment_inspection_files as $equipment_inspection) {

                $uploadpath = 'public/uploads/incident/investigation/' . $investigation->investigation_id;

                $folderPath = public_path('uploads/incident/investigation/' . $investigation->investigation_id);

                if (!File::exists($folderPath)) {

                    File::makeDirectory($folderPath, 0755, true);
                }

                $filenewname = time() . Str::random('10') . '.' . $equipment_inspection->getClientOriginalExtension();

                $fileName = $equipment_inspection->getClientOriginalName();
                $fileSize = $equipment_inspection->getSize();

                $fileExt = $equipment_inspection->getClientOriginalExtension();

                $equipment_inspection->move($uploadpath, $filenewname);

                $path = $uploadpath . "/" . $filenewname;
                $user_id = Auth::id();

                $insert_data = array(
                    'investigation_id' => $investigation->id,
                    'type_id' => 5,
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

        if ($training_records_files != null) {

            foreach ($training_records_files as $training_records) {

                $uploadpath = 'public/uploads/incident/investigation/' . $investigation->investigation_id;

                $folderPath = public_path('uploads/incident/investigation/' . $investigation->investigation_id);

                if (!File::exists($folderPath)) {

                    File::makeDirectory($folderPath, 0755, true);
                }

                $filenewname = time() . Str::random('10') . '.' . $training_records->getClientOriginalExtension();

                $fileName = $training_records->getClientOriginalName();
                $fileSize = $training_records->getSize();

                $fileExt = $training_records->getClientOriginalExtension();

                $training_records->move($uploadpath, $filenewname);

                $path = $uploadpath . "/" . $filenewname;
                $user_id = Auth::id();

                $insert_data = array(
                    'investigation_id' => $investigation->id,
                    'type_id' => 6,
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

        if ($other_records_files != null) {

            foreach ($other_records_files as $other_records) {

                $uploadpath = 'public/uploads/incident/investigation/' . $investigation->investigation_id;

                $folderPath = public_path('uploads/incident/investigation/' . $investigation->investigation_id);

                if (!File::exists($folderPath)) {

                    File::makeDirectory($folderPath, 0755, true);
                }

                $filenewname = time() . Str::random('10') . '.' . $other_records->getClientOriginalExtension();

                $fileName = $other_records->getClientOriginalName();
                $fileSize = $other_records->getSize();

                $fileExt = $other_records->getClientOriginalExtension();

                $other_records->move($uploadpath, $filenewname);

                $path = $uploadpath . "/" . $filenewname;
                $user_id = Auth::id();

                $insert_data = array(
                    'investigation_id' => $investigation->id,
                    'type_id' => 7,
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


    public function getfiles($id, $type)
    {
        return $this->where('investigation_id', $id)->where('type_id', $type)->get();
    }


    protected static function booted()
    {
        static::addGlobalScope(new TrashScope('incident_investigation_files'));
    }
}
