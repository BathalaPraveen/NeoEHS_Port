<?php

namespace App\Http\Controllers\Master;

use PDF;
use Exception;
use DataTables;
use App\Models\User;

use Illuminate\Http\Request;
use App\Models\Master\Company;
use App\Http\Controllers\Controller;
use App\Models\Master\WorkTypeMaster;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Spatie\SimpleExcel\SimpleExcelWriter;

class WorkTypeMasterController extends Controller
{
    private $work_type;
    private $company;
    private $users;

    public function __construct()
    {

        $this->work_type = new WorkTypeMaster();
        $this->company = new Company();
        $this->users = new User();
    }

    public function index(Request $request)
    {

        if (Auth::check()) {
            if ($request->ajax()) {
                try {

                    $data =  $this->work_type->list();
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
                            $btn = '<a href="' . admin_url('work_type/view/' . encryptId($row->id)) . '"   class="" title="View"><i class="fa-solid fa-eye"></i></a> ';
                            $btn .= '<a href="' . admin_url('work_type/edit/' . encryptId($row->id)) . '" class=" " title="Edit"><i class="fa-solid fa-pen-to-square"></i> ';
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

        return view('master.work_type.list', $data);
    }

    public function Add(Request $request)
    {
        try {
            $companyDetails =  $this->company->getAllCompany();
            $employeeDetails =  $this->users->getAllDataBasedRole(ROLE_SUPERVISING_AUTHORITY);
            $data = array(
                'companyDetails' => $companyDetails,
                'employeeDetails' => $employeeDetails,
            );
            return view('master.work_type.add', $data);
        } catch (Exception $ex) {
            report($ex);
        }
    }

    public function Store(Request $request)
    {
        try {
            $rules = [
                'work_type_name' => 'required',
            ];
            $messages = [
                'work_type_name.required' => 'Please enter Work Type Name',
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            try {

                $this->work_type->store();

                Session::flash('success', 'Work Type added successfully!');
            } catch (Exception $ex) {


                Session::flash('error', 'Something went wrong, Please try after sometimes!');
            }

            return redirect(admin_url('work_type/list'));
        } catch (Exception $ex) {


            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('work_type/list'));
        }
    }

    public function View(Request $request)
    {
        try {
            $id = decryptId($request->id);
            if (Auth::check()) {
                $work_type = $this->work_type->selectOne($id);

                $data = array(
                    'work_type' => $work_type,
                );
            }
            return view('master.work_type.view', $data);
        } catch (Exception $ex) {
            report($ex);
        }
    }

    public function Edit(Request $request)
    {
        try {
            $id = decryptId($request->id);
            $work_type = $this->work_type->find($id);
            $companyDetails =  $this->company->getAllCompany();
            $employeeDetails =  $this->users->getAllDataBasedRole(ROLE_SUPERVISING_AUTHORITY);

            $data = array(
                'work_type' => $work_type,
                'companyDetails' => $companyDetails,
                'employeeDetails' => $employeeDetails,
            );
            return view('master.work_type.edit', $data);
        } catch (Exception $error) {
            report($error->getMessage());
        }
    }

    public function Update(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $rules = [
                'work_type_name' => 'required',

            ];
            $messages = [
                'work_type_name.required' => 'Please enter Work Type Name',

            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $this->work_type->updates($id);

            Session::flash('success', 'Work Type updated successfully!');
            return redirect(admin_url('work_type/list'));
        } catch (Exception $ex) {

            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('work_type/list'));
        }
    }

    public function Uniquecheck(Request $request)
    {
        if ($request->ajax()) {
            $email = $request->email;
            $userid = $request->userid;
            if ($userid == '') {
                $user = $this->users->EmailCheck($email);
            } else {
                $user = $this->users->ExistEmailCheck($email, $userid);
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

            $this->work_type->statuschange($id);

            return response()->json(['status' => 'success', 'msg' => 'Work Type status changed'], 200);
        } catch (Exception $ex) {

            return response()->json(['status' => 'error', 'msg' => 'Please try after some time'], 406);
        }
    }

    public function Delete(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $this->work_type->deleterecord($id);

            return response()->json(['status' => 'success', 'msg' => 'Work Type deleted successfully'], 200);
        } catch (Exception $ex) {

            return response()->json(['status' => 'error', 'msg' => 'Please try after some time'], 406);
        }
    }

    public function ExportExcel(Request $request)
    {

        try {

            $allData = $this->work_type->exportdata();

            $header = [
                'No.',
                'Work Type ID',
                'Work Type Name',
                'Work Type Description',
                'Work Type Status',
                'Created Date',
            ];

            $i = 1;
            foreach ($allData as $data) {

                $export = [];
                $export['No.'] =  $i;
                $export['Work Type ID'] =  $data->work_type_id;
                $export['Work Type Name'] =  $data->work_type_name;
                $export['Work Type Description'] =  $data->work_type_description;
                $export['Work Type Status'] =  $data->status == 1 ? 'Active' : 'In-Active';
                $export['Created Date'] =  Displaydateformat($data->created_at);

                $exportData[] = $export;

                $i++;
            }

            $writer = SimpleExcelWriter::streamDownload('Work_Type.xlsx')
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

            $allData = $this->work_type->exportdata();

            $header = [
                'No.',
                'Company Name',
                'Work Type ID',
                'Work Type Name',
                'Work Type Address',
                'Work Type Status',
                'Created Date',
            ];

            $data = array(
                'header' => $header,
                'content' => $allData,
                'pagetitle' => "Work Type Details",
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

            $view = view('master.work_type.pdf', $data);
            $html = $view->render();



            $mpdf->WriteHTML($html);

            $filename = "Work Type Details.pdf";
            $mpdf->Output($filename, 'D');
        } catch (Exception $ex) {

            report($ex);
        }
    }

    public function list(Request $request)
    {

        $conpanyId = decryptId($request->companyId);

        $work_type = $this->work_type->ajaxList($conpanyId);

        return response()->json($work_type);
    }

    public function getSupervisingAuthority(Request $request)
    {

        $work_type_details = decryptId($request->id);
        $supervising_authority = $this->work_type->selectOne($work_type_details)->supervising_authority;
        $Location = $this->users->ajaxList($supervising_authority);

        return response()->json($Location);
    }
}
