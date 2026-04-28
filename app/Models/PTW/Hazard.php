<?php

namespace App\Models\PTW;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


use App\Scopes\TrashScope;

class Hazard extends Model
{
    use  HasFactory;


    protected $table = 'ptw_general_hazard';
    protected $primaryKey = 'id';

    protected $fillable = [
        'ptw_id',
        'seq_of_bas_job_stp',
        'hazard_category',
        'hazard_category_incident',
        'who_what_harmed',
        'seo_mea_or_rec_act_or_pro',
        'likelihood',
        'severity',
        'risk_matrix',
        'action_responsible',
        'created_by',
        'updated_by',
        'status',
        'trash',
        'created_at',
        'updated_at',
    ];

    protected $attributes = [
        'status' => 1,
        'trash' => 'NO',
    ];


    public function store($ptw)
    {

        $request = request();

        $hazardData = $request->jsadetails;

        foreach ($hazardData as $hazard) {

            $risk_matrix =  $hazard['likelihood'] * $hazard['severity'];

            $insert_array = array(
                'ptw_id' => $ptw->id,
                'seq_of_bas_job_stp' => $hazard['seq_of_bas_job_stp'],
                'hazard_category' => decryptId($hazard['hazard_category']),
                'hazard_category_incident' => decryptId($hazard['hazard_category_incident']),
                'hazard_category_incident_other' => $hazard['hazard_category_incident_other'],
                'who_what_harmed' => $hazard['who_what_harmed'],
                'seo_mea_or_rec_act_or_pro' => $hazard['seo_mea_or_rec_act_or_pro'],
                'likelihood' => $hazard['likelihood'],
                'severity' => $hazard['severity'],
                'risk_matrix' => $risk_matrix,
                'action_responsible' => $hazard['action_responsible'],
                'created_by' => Auth::id()
            );

            $this->create($insert_array);
        }

        return true;
    }

    public function updates($ptw)
    {
        $request = request();
        $ptw_id = $ptw->id;

        $details_of_table = $this->where('ptw_id', $ptw_id)->get();
        $existingIds = $details_of_table->pluck('id')->toArray();
        $submittedIds = $request->upload_id ?? [];
        $hazardData = $request->jsadetails;

        foreach ($existingIds as $oldId) {
            if (!in_array($oldId, $submittedIds)) {
                $this->where('id', $oldId)->update([
                    'trash' => 'YES',
                    'status' => 0,
                ]);
            }
        }

        foreach ($hazardData as $key => $hazard) {

            $key = $key - 1;
            $risk_matrix = $hazard['likelihood'] * $hazard['severity'];

            $data = [
                'ptw_id' => $ptw_id,
                'seq_of_bas_job_stp' => $hazard['seq_of_bas_job_stp'],
                'hazard_category' => decryptId($hazard['hazard_category']),
                'hazard_category_incident' => decryptId($hazard['hazard_category_incident']),
                'hazard_category_incident_other' => $hazard['hazard_category_incident_other'],
                'who_what_harmed' => $hazard['who_what_harmed'],
                'seo_mea_or_rec_act_or_pro' => $hazard['seo_mea_or_rec_act_or_pro'],
                'likelihood' => $hazard['likelihood'],
                'severity' => $hazard['severity'],
                'risk_matrix' => $risk_matrix,
                'action_responsible' => $hazard['action_responsible'],
            ];

            if (!empty($submittedIds[$key])) {
                $data['updated_by'] = Auth::id();

                $this->where('id', $submittedIds[$key])->update($data);
            } else {
                dd($data);
                $data['created_by'] = Auth::id();
                $this->create($data);
            }

        }
    }


    public function getgeneral($ptw_id)
    {

        $data =  $this->select('ptw_general_hazard.*', 'ptw_master_hazard_category.category_name', 'ptw_master_hazard_subcategory.subcategory_name')
            ->leftJoin('ptw_master_hazard_category', 'ptw_general_hazard.hazard_category', '=', 'ptw_master_hazard_category.id')
            ->leftJoin('ptw_master_hazard_subcategory', 'ptw_general_hazard.hazard_category_incident', '=', 'ptw_master_hazard_subcategory.id')
            ->where('ptw_id', $ptw_id)
            ->get();

        return $data;
    }

    protected static function booted()
    {
        static::addGlobalScope(new TrashScope('ptw_general_hazard'));
    }
}
