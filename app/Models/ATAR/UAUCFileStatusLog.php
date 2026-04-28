<?php

namespace App\Models\ATAR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Str;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\File;

use App\Scopes\TrashScope;

use App\Models\User;
use App\Models\ATAR\UAUCStatus;

class UAUCFileStatusLog extends Model
{
    use  HasFactory;


    protected $table = 'atar_uauc_status_log';
    protected $primaryKey = 'id';

    protected $fillable = [
        'atar_id',
        'from_status',
        'to_status',
        'status_description',
        'created_by',
        'status',
        'trash',
        'created_at',
        'updated_at'

    ];

    protected $attributes = [
        'status' => 1,
        'trash' => 'NO',
    ];


    // Relationship with user
    public function userInfo()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    // Relationship with Status

    public function statusFromInfo()
    {
        return $this->belongsTo(UAUCStatus::class, 'from_status', 'id');
    }

    public function statusToInfo()
    {
        return $this->belongsTo(UAUCStatus::class, 'to_status', 'id');
    }


    public function add($insert_array)
    {

        $request = request();

        return $this->create($insert_array);
    }

    public function store($status)
    {

        $request = request();

        $uauc_status = decryptId($request->uauc_status);

        if($uauc_status == null || $uauc_status == ''){
            $uauc_status = 5;
        }
        switch ($uauc_status) {
            case "2":
                $description = $request->accept_desc;
                break;
            case "3":
                $description = $request->reassign_desc;
                break;
            case "4":
                $description = $request->irrelavant_desc;
                break;
            case "5":
                $description = !empty($request->close_desc) ? $request->close_desc : $request->hsc_remarks;
                break;

            case "6":
                $description = $request->duplicate_desc;
                break;

            case "7":
                $description = $request->close_desc;
                break;
        }

        $insert_array = [
            'atar_id' => $status['id'],
            'from_status' => $status['from_status'],
            'to_status' => $status['to_status'],
            'status_description' => $description,
            'created_by' => Auth::id(),

        ];

        return $this->create($insert_array);
    }

    public function getatarstatus($atar_id)
    {
        $query = $this->select('atar_uauc_status_log.*', 'atar_uauc_status.atar_status', 'users.name')
            ->leftJoin('atar_uauc_status', 'atar_uauc_status_log.to_status', '=', 'atar_uauc_status.id')
            ->leftJoin('users', 'atar_uauc_status_log.created_by', '=', 'users.id');
        return $this->where('atar_id', $atar_id)->get();
    }


    protected static function booted()
    {
        static::addGlobalScope(new TrashScope('atar_uauc_status_log'));
    }
}
