<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Str;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;


use App\Scopes\TrashScope;

class SliderImage extends Model
{
    use  HasFactory;


    protected $table = 'template_sliders';
    protected $primaryKey = 'id';

    protected $fillable = [
        'page_type',
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

    public function getAll()
    {
        return $this->where('page_type', 1)->get();
    }

    public function store()
    {

        $request = request();

        $supportDocument = $request->file('sliderimage');

        if ($supportDocument != null) {

            foreach ($supportDocument as $key => $ducument) {

                $uploadpath = 'public/uploads/master/dashboard/slider';

                $folderPath = public_path('uploads/master/dashboard/slider');

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
                    'page_type' => 1,
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

    public function remove($id)
    {
        return $this->where('id', $id)->update(['status' => 0, 'trash' => 'YES']);
    }

    protected static function booted()
    {
        static::addGlobalScope(new TrashScope('template_sliders'));
    }
}
