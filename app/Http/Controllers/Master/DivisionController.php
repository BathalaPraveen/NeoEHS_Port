<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\SimpleExcel\SimpleExcelWriter;

use PDF;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;


use App\Models\Master\Company;
use App\Models\Master\Division;

class DivisionController extends Controller
{

    private $company;
    private $division;

    public function __construct()
    {

        $this->company = new Company();
        $this->division = new Division();
    }



    public function index(Request $request)
    {

        if (Auth::check()) {
            if ($request->ajax()) {
                try {

                    $data =  $this->division->list();

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
                            $btn = '<a href="' . admin_url('division/view/' . encryptId($row->id)) . '"   class="" title="View"><i class="fa-solid fa-eye"></i></a> ';
                            $btn .= '<a href="' . admin_url('division/edit/' . encryptId($row->id)) . '" class=" " title="Edit"><i class="fa-solid fa-pen-to-square"></i> ';
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
                    report($ex);
                    return response()->json(['status' => 'error', 'msg' => 'Please try after some time'], 406);
                }
            }
        }

        $data = array();

        return view('master.division.list', $data);
    }

    public function Add(Request $request)
    {

        try {

            $companyDetails = $this->company->getAllCompany();
            $data = array(
                'companyDetails' => $companyDetails
            );
            return view('master.division.add', $data);
        } catch (Exception $ex) {
            report($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('division/list'));
        }
    }

    public function Store(Request $request)
    {
        try {

            $rules = [
                'division_id' => 'required',
                'company_id' => 'required',
                'division_name' => 'required',
                'division_shortname' => 'required',
            ];
            $messages = [
                'division_id.required' => 'Please enter Division ID',
                'company_id.required' => 'Please enter Division Name',
                'division_name.required' => 'Please enter Division  Name',
                'division_shortname.required' => 'Please enter Division  Description',

            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }



            $this->division->store();

            Session::flash('success', 'Division  added successfully!');
            return redirect(admin_url('division/list'));
        } catch (Exception $ex) {

            report($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('division/list'));
        }
    }

    public function View(Request $request)
    {
        try {
            $id = decryptId($request->id);
            if (Auth::check()) {

                $division = $this->division->selectOne($id);

                $data = array(
                    'division' => $division,
                );
            }
            return view('master.division.view', $data);
        } catch (Exception $ex) {
            report($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('division/list'));
        }
    }

    public function Edit(Request $request)
    {
        try {
            $id = decryptId($request->id);
            $companyDetails = $this->company->getAllCompany();

            $division = $this->division->selectOne($id);
            $data = array(
                'division' => $division,
                'companyDetails' => $companyDetails,
            );
            return view('master.division.edit', $data);
        } catch (Exception $ex) {
            report($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('division/list'));
        }
    }

    public function Update(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $rules = [
                'division_id' => 'required',
                'company_id' => 'required',
                'division_name' => 'required',
                'division_shortname' => 'required',
            ];
            $messages = [
                'division_id.required' => 'Please enter Division ID',
                'company_id.required' => 'Please enter Division Name',
                'division_name.required' => 'Please enter Division  Name',
                'division_shortname.required' => 'Please enter Division  Description',

            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $this->division->updates($id);

            Session::flash('success', 'Division updated successfully!');
            return redirect(admin_url('division/list'));
        } catch (Exception $ex) {
            report($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('division/list'));
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

            $this->division->statuschange($id);

            return response()->json(['status' => 'success', 'msg' => 'Division status changed'], 200);
        } catch (Exception $ex) {

            return response()->json(['status' => 'error', 'msg' => 'Please try after some time'], 406);
        }
    }

    public function Delete(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $this->division->deleterecord($id);

            return response()->json(['status' => 'success', 'msg' => 'Division deleted successfully'], 200);
        } catch (Exception $ex) {

            return response()->json(['status' => 'error', 'msg' => 'Please try after some time'], 406);
        }
    }


    public function ExportExcel(Request $request)
    {

        try {

            $allData = $this->division->exportdata();

            $header = [
                'No.',
                'Division ID',
                'Company Name',
                'Division Name',
                'Division Short Name',
                'Division Status',
                'Created Date',
            ];

            $i = 1;
            foreach ($allData as $data) {

                $export = [];
                $export['No.'] =  $i;
                $export['Division ID'] =  $data->location_id;
                $export['Company Name'] =  $data->company_name;
                $export['Division Name'] =  $data->division_name;
                $export['Division Short Name'] =  $data->division_shortname;
                $export['Division Status'] =  $data->status == 1 ? 'Active' : 'In-Active';
                $export['Created Date'] =  Displaydateformat($data->created_at);

                $exportData[] = $export;

                $i++;
            }

            $writer = SimpleExcelWriter::streamDownload('Division.xlsx')
                ->addHeader($header)
                ->addRows(
                    $exportData
                );
        } catch (Exception $ex) {

           report($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('division/list'));
        }
    }

    public function ExportPdf(Request $request)
    {

        try {

            $allData = $this->division->exportdata();

            $header = [
                'No.',
                'Division ID',
                'Company Name',
                'Division Name',
                'Division Short Name',
                'Division Status',
                'Created Date',
            ];

            $data = array(
                'header' => $header,
                'content' => $allData,
                'pagetitle' => "Division Details",
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

            $view = view('master.division.pdf', $data);
            $html = $view->render();



            $mpdf->WriteHTML($html);

            $filename = "Division.pdf";
            $mpdf->Output($filename, 'D');
        } catch (Exception $ex) {

            report($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('division/list'));
        }
    }

    public function list(Request $request)
    {

        $componyId = decryptId($request->companyId);

        $division = $this->division->ajaxList($componyId);
        return response()->json($division);
    }
}
