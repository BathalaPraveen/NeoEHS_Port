<?php

namespace App\Models\ATAR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Str;
use Illuminate\Support\Facades\Auth;

use App\Scopes\TrashScope;

class UAUCStatus extends Model
{
    use  HasFactory;


    protected $table = 'atar_uauc_status';
    protected $primaryKey = 'id';

    protected $fillable = [
        'atar_status',
        'status',
        'trash',
    ];

    protected $attributes = [
        'status' => 1,
        'trash' => 'NO',
    ];

    public function getstatus($status = '')
    {

        $query = $this->select('*');

        if ($status != '') {

            switch ($status) {
                case 1:
                    $whereIn = [2,3,4,6];
                    break;
                case 2:
                    $whereIn = [2,5];
                    break;
                case 3:
                    $whereIn = [3,2,4,6];
                    break;
                case 4:
                    $whereIn = [4];
                    break;
                case 5:
                    $whereIn = [5];
                    break;
                default:

                    $whereIn = [];
                    break;
            }

            if(count($whereIn) > 0){
                $query->whereIn('id',$whereIn);
            }

        }

        $data = $query->get();
        return  $data;
    }


    protected static function booted()
    {
        static::addGlobalScope(new TrashScope('atar_uauc_status'));
    }
}
