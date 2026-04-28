<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\SimpleExcel\SimpleExcelWriter;

use PDF;
use Illuminate\Support\Facades\Auth;
use Session;
use Exception;
use DataTables;

use App\Models\Master\Company;
use App\Models\Master\Division;
use App\Models\Master\Department;
use App\Models\User;

class DepartmentController extends Controller
{


    private $company;
    private $division;
    private $department;
    private $users;

    public function __construct()
    {

        $this->company = new Company();
        $this->division = new Division();
        $this->department = new Department();
        $this->users = new User();

    }



    public function index(Request $request)
    {

        if (Auth::check()) {
            if ($request->ajax()) {
                try {

                    $data =  $this->department->list();

                    $datatables = Datatables::of($data['data'])
                        ->addIndexColumn()
                        ->addColumn('status', function ($row) {
                            $text = "<span style='color:red'>In-Active<span>";
                            if ($row->status == 1) {
                                $text = "<span style='color:green;cursor:pointer' class= 'StatusChange' data-id='" . encryptId($row->id) . "' data-type = '1' >Active<span>";
                            } else if ($row->status == 0) {
                                $text = "<span style='color:red;cursor:pointer' class= 'StatusChange' data-id='" . encryptId($row->id) . "' data-type = '0' >In-Active<span>";
                            }
                            return $text;
                        })
                        ->addColumn('action', function ($row) {
                            $btn = '';
                            $btn = '<a href="' . admin_url('department/view/' . encryptId($row->id)) . '"   class="" title="View"><i class="fa-solid fa-eye"></i></a> ';
                            $btn .= '<a href="' . admin_url('department/edit/' . encryptId($row->id)) . '" class=" " title="Edit"><i class="fa-solid fa-pen-to-square"></i> ';
                            $btn .= '<a href="javascript:void(0);"  data-id="' . encryptId($row->id) . '"  class="recordDelete" title="Delete"><i class="fa-solid fa-trash text-danger" ></i></i></a> ';
                            return $btn;
                        })
                        ->rawColumns(['action', 'created_date', 'created_by', 'status'])
                        ->setFilteredRecords($data['total_records'])
                        ->setTotalRecords($data['total_records'])
                        ->skipPaging()
                        ->make(true);
                    return $datatables;
                } catch (Exception $ex) {

                    return response()->json(['status' => 'error', 'msg' => 'Please try after some time'], 406);
                }
            }
        }

        $data = array();

        return view('master.department.list', $data);
    }

    public function Add(Request $request)
    {

        try {

            $companyDetails = $this->company->getAllCompany();
            $employeeDetails =  $this->users->getAlluser();

            $data = array(
                'companyDetails' => $companyDetails,
                'employeeDetails' => $employeeDetails
            );
            return view('master.department.add', $data);
        } catch (Exception $ex) {
            report($ex);
        }
    }

    public function Store(Request $request)
    {
        try {
            $rules = [
                'company_id' => 'required',
                'division_id' => 'required',
                'department_name' => 'required',
                'department_shortname' => 'required',
            ];
            $messages = [
                'company_id.required' => 'Please enter Division ID',
                'division_id.required' => 'Please enter Division Name',
                'department_name.required' => 'Please enter Division  Name',
                'department_shortname.required' => 'Please enter Division  Description',

            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            try {

                $this->department->store();

                Session::flash('success', 'Department added successfully!');
            } catch (Exception $ex) {


                Session::flash('error', 'Something went wrong, Please try after sometimes!');
            }

            return redirect(admin_url('department/list'));
        } catch (Exception $ex) {


            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('department/list'));
        }
    }

    public function View(Request $request)
    {
        try {
            $id = decryptId($request->id);
            if (Auth::check()) {

                $department = $this->department->selectOne($id);

                $data = array(
                    'department' => $department,
                );
            }
            return view('master.department.view', $data);
        } catch (Exception $ex) {
            report($ex);
        }
    }

    public function Edit(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $companyDetails = $this->company->getAllCompany();
            $divisionDetails = $this->division->getAllDivision();


            $division = $this->department->selectOne($id);
            $employeeDetails =  $this->users->getAlluser();

            $data = array(
                'division' => $division,
                'companyDetails' => $companyDetails,
                'divisionDetails' => $divisionDetails,
                'employeeDetails' => $employeeDetails,
            );
            return view('master.department.edit', $data);
        } catch (Exception $error) {
            report($error->getMessage());
        }
    }

    public function Update(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $rules = [
                'company_id' => 'required',
                'division_id' => 'required',
                'department_name' => 'required',
                'department_shortname' => 'required',
            ];
            $messages = [
                'company_id.required' => 'Please enter Company ID',
                'division_id.required' => 'Please enter Division Name',
                'department_name.required' => 'Please enter Department  Name',
                'department_shortname.required' => 'Please enter Department  Description',

            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $this->department->updates($id);

            Session::flash('success', 'Department updated successfully!');
            return redirect(admin_url('department/list'));
        } catch (Exception $ex) {



            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('department/list'));
        }
    }

    public function Uniquecheck(Request $request)
    {
        if ($request->ajax()) {
            $email = $request->email;
            $userid = $request->userid;
            if ($userid == '') {
                $user = $this->user->EmailCheck($email);
            } else {
                $user = $this->user->ExistEmailCheck($email, $userid);
            }
            if ($user->count()) {
                return Response::json(array('msg' => 'true'));
            }
            return Response::json(array('msg' => 'false'));
        }
    }

    public function StatusChange(Request $request)
    {

        try {
            $id = decryptId($request->id);

            $this->department->statuschange($id);

            return response()->json(['status' => 'success', 'msg' => 'Department status changed'], 200);
        } catch (Exception $ex) {

            return response()->json(['status' => 'error', 'msg' => 'Please try after some time'], 406);
        }
    }

    public function Delete(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $this->department->deleterecord($id);

            return response()->json(['status' => 'success', 'msg' => 'Department deleted successfully'], 200);
        } catch (Exception $ex) {

            return response()->json(['status' => 'error', 'msg' => 'Please try after some time'], 406);
        }
    }


    public function ExportExcel(Request $request)
    {

        try {

            $allData = $this->department->exportdata();

            $header = [
                'No.',
                'Department ID',
                'Company Name',
                'Division Name',
                'Department Name',
                'Department Short Name',
                'Department Status',
                'Created Date',
            ];

            $i = 1;
            foreach ($allData as $data) {

                $export = [];
                $export['No.'] =  $i;
                $export['Department ID'] =  $data->department_id;
                $export['Company Name'] =  $data->company_name;
                $export['Division Name'] =  $data->division_name;
                $export['Department Name'] =  $data->department_name;
                $export['Department Short Name'] =  $data->department_shortname;
                $export['Department Status'] =  $data->status == 1 ? 'Active' : 'In-Active';
                $export['Created Date'] =  Displaydateformat($data->created_at);

                $exportData[] = $export;

                $i++;
            }

            $writer = SimpleExcelWriter::streamDownload('Department.xlsx')
                ->addHeader($header)
                ->addRows(
                    $exportData
                );
        } catch (Exception $ex) {

            report($ex);
        }
    }

    public function ExportPdf(Request $request)
    {

        try {

            $allData = $this->department->exportdata();

            $header = [
                'No.',
                'Department ID',
                'Company Name',
                'Division Name',
                'Department Name',
                'Department Short Name',
                'Department Status',
                'Created Date',
            ];

            $data = array(
                'header' => $header,
                'content' => $allData,
                'pagetitle' => "Department Details",
            );

            $property = [
                'tempDir' => 'public/pdf/temp/',
                'mode' => 'c',
                'margin_left' => 10,
                'margin_right' => 10,
                'margin_top' => 10,

            ];

            $mpdf = new \Mpdf\Mpdf($property);
            $mpdf->setAutoTopMargin = 'stretch';

            $view = view('master.department.pdf', $data);
            $html = $view->render();



            $mpdf->WriteHTML($html);

            $filename = "Department.pdf";
            $mpdf->Output($filename, 'D');
        } catch (Exception $ex) {

            report($ex);
        }
    }

    public function list(Request $request){

        $divisionId = decryptId($request->divisionId);

        $division = $this->department->ajaxList($divisionId);
        return response()->json($division);

    }
}

