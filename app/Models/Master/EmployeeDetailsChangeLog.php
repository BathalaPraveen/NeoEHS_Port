<?php

namespace App\Models\Master;

use App\Scopes\TrashScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployeeDetailsChangeLog extends Model
{
    use  HasFactory;


    protected $table = 'master_employee_details_change_log';
    protected $primaryKey = 'id';

    protected $fillable = [
        'from_emp_id',
        'from_designation_id',
        'from_company_id',
        'from_division_id',
        'from_department_id',
        'from_location_id',
        'from_specfic_location',
        
        'to_emp_id',
        'to_designation_id',
        'to_company_id',
        'to_division_id',
        'to_department_id',
        'to_location_id',
        'to_specfic_location',
    
        'remarks',
        'created_by',
        'updated_by',
        'status',
        'trash',
    ];
    

    protected $attributes = [
        'status' => 1,
        'trash' => 'NO',
    ];

    public function store($empdetails_old,$empdetails_new)
    {

        $request = request();

        $insert_array = array(
                
            'form_emp_id' => $empdetails_old->emp_id,
            'from_company_id' => $empdetails_old->emp_company_id,
            'from_division_id' => $empdetails_old->emp_division_id,
            'from_department_id' => $empdetails_old->emp_department_id,

            'to_emp_id' => $empdetails_new->emp_id,
            'to_company_id' => $empdetails_new->emp_company_id,
            'to_division_id' => $empdetails_new->emp_division_id,
            'to_department_id' => $empdetails_new->emp_department_id,
            
            'remarks' => $request->remarks,
            'created_by' => Auth::id(),

        );

        return $this->create($insert_array);
    }

    protected static function booted()
    {
        static::addGlobalScope(new TrashScope('master_employee'));
    }
}
