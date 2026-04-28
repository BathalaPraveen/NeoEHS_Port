<?php

namespace App\Models\PTW;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Str;
use Illuminate\Support\Facades\Auth;

use App\Scopes\TrashScope;

class PTWSubPermit extends Model
{
    use  HasFactory;


    protected $table = 'ptw_sub_permit';
    protected $primaryKey = 'id';

    protected $fillable = [
        'ptw_id',
        'sub_permit_id',
        'sub_permit_status',
        'created_by',
        'updated_by',
        'status',
        'trash',
        'created_at',
        'updated_at'

    ];

    protected $attributes = [
        'status' => 1,
        'trash' => 'NO',
    ];


    public function store($ptwid, $subpermit = [])
    {

        foreach ($subpermit as $permit) {
            $insertArray = array(
                'ptw_id' => $ptwid,
                'sub_permit_id' => $permit,
                'sub_permit_status' => 0,
                'created_by' => Auth::id()
            );
            $this->create($insertArray);
        }

        return $this->where('ptw_id', $ptwid)->where('sub_permit_status', 0)->orderBy('id', 'ASC')->first();
    }

    public function nextpermit($ptwid, $sub_permit_id = '')
    {
        $nextpermit = $this->where('ptw_id', $ptwid)->where('sub_permit_status', 0);

        if ($sub_permit_id != '')
            $nextpermit = $nextpermit->where('sub_permit_id', '!=', $sub_permit_id);

        $nextpermit = $nextpermit->orderBy('id', 'ASC')->first();

        return $nextpermit;
    }

    public function updatePermit($ptwid, $sub_permit_id)
    {

        $nextpermit = $this->where('ptw_id', $ptwid)
            ->where('sub_permit_id', $sub_permit_id)
            ->update(['sub_permit_status' => 1]);

        return $nextpermit;
    }

    public function statuschange($ptwId, $ptwType, $status)
    {

        $update_data = array(
            'sub_permit_status' => $status,
        );

        $where_array = array(
            'ptw_id' => $ptwId,
            'sub_permit_id' => $ptwType,
        );

        return $this->where($where_array)->update($update_data);
    }

    public function getPermit($ptwid)
    {

        $subpermit = $this->select('ptw_sub_permit.*', 'ptw_master_subwork_permit.permit_name')->leftJoin('ptw_master_subwork_permit', 'ptw_master_subwork_permit.id', '=', 'ptw_sub_permit.sub_permit_id')
            ->where('ptw_id', $ptwid)
            ->orderBy('ptw_sub_permit.sub_permit_id', 'ASC')
            ->get();

        return $subpermit;
    }

    protected static function booted()
    {
        static::addGlobalScope(new TrashScope('ptw_sub_permit'));
    }
}
