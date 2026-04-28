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
use App\Models\Master\Location;
use App\Models\User;

class LocationController extends Controller
{
    private $location;
    private $company;
    private $users;

    public function __construct()
    {

        $this->location = new Location();
        $this->company = new Company();
        $this->users = new User();
    }

    public function index(Request $request)
    {

        if (Auth::check()) {
            if ($request->ajax()) {
                try {

                    $data =  $this->location->list();
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
                            $btn = '<a href="' . admin_url('location/view/' . encryptId($row->id)) . '"   class="" title="View"><i class="fa-solid fa-eye"></i></a> ';
                            $btn .= '<a href="' . admin_url('location/edit/' . encryptId($row->id)) . '" class=" " title="Edit"><i class="fa-solid fa-pen-to-square"></i> ';
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

        return view('master.location.list', $data);
    }

    public function Add(Request $request)
    {
        try {
            $companyDetails =  $this->company->getAllCompany();
            $data = array(
                'companyDetails' => $companyDetails,
            );
            return view('master.location.add', $data);
        } catch (Exception $ex) {
            report($ex);
        }
    }

    public function Store(Request $request)
    {
        try {
            $rules = [
                'company_id' => 'required',
                'location_id' => 'required',
                'location_name' => 'required',
            ];
            $messages = [
                'company_id.required' => 'Please select Company Name',
                'location_id.required' => 'Please enter Location ID',
                'location_name.required' => 'Please enter Location Name',
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            try {

                $this->location->store();

                Session::flash('success', 'Location added successfully!');
            } catch (Exception $ex) {


                Session::flash('error', 'Something went wrong, Please try after sometimes!');
            }

            return redirect(admin_url('location/list'));
        } catch (Exception $ex) {


            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('location/list'));
        }
    }

    public function View(Request $request)
    {
        try {
            $id = decryptId($request->id);
            if (Auth::check()) {
                $location = $this->location->selectOne($id);

                $data = array(
                    'location' => $location,
                );
            }
            return view('master.location.view', $data);
        } catch (Exception $ex) {
            report($ex);
        }
    }

    public function Edit(Request $request)
    {
        try {
            $id = decryptId($request->id);
            $location = $this->location->find($id);
            $companyDetails =  $this->company->getAllCompany();

            $data = array(
                'location' => $location,
                'companyDetails' => $companyDetails,
            );
            return view('master.location.edit', $data);
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
                'location_id' => 'required',
                'location_name' => 'required',

            ];
            $messages = [
                'location_id.required' => 'Please select Company ID',
                'location_id.required' => 'Please enter Location ID',
                'location_name.required' => 'Please enter Location Name',

            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $this->location->updates($id);

            Session::flash('success', 'Location updated successfully!');
            return redirect(admin_url('location/list'));
        } catch (Exception $ex) {

            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('location/list'));
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

            $this->location->statuschange($id);

            return response()->json(['status' => 'success', 'msg' => 'Location status changed'], 200);
        } catch (Exception $ex) {

            return response()->json(['status' => 'error', 'msg' => 'Please try after some time'], 406);
        }
    }

    public function Delete(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $this->location->deleterecord($id);

            return response()->json(['status' => 'success', 'msg' => 'Location deleted successfully'], 200);
        } catch (Exception $ex) {

            return response()->json(['status' => 'error', 'msg' => 'Please try after some time'], 406);
        }
    }

    public function ExportExcel(Request $request)
    {

        try {

            $allData = $this->location->exportdata();

            $header = [
                'No.',
                'Company Name',
                'Location ID',
                'Location Name',
                'Location Address',
                'Location Status',
                'Created Date',
            ];

            $i = 1;
            foreach ($allData as $data) {

                $export = [];
                $export['No.'] =  $i;
                $export['Company Name'] =  $data->company_name;
                $export['Location ID'] =  $data->location_id;
                $export['Location Name'] =  $data->location_name;
                $export['Location Address'] =  $data->location_address;
                $export['Location Status'] =  $data->status == 1 ? 'Active' : 'In-Active';
                $export['Created Date'] =  Displaydateformat($data->created_at);

                $exportData[] = $export;

                $i++;
            }

            $writer = SimpleExcelWriter::streamDownload('Location.xlsx')
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

            $allData = $this->location->exportdata();

            $header = [
                'No.',
                'Company Name',
                'Location ID',
                'Location Name',
                'Location Address',
                'Location Status',
                'Created Date',
            ];

            $data = array(
                'header' => $header,
                'content' => $allData,
                'pagetitle' => "Location Details",
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

            $view = view('master.location.pdf', $data);
            $html = $view->render();



            $mpdf->WriteHTML($html);

            $filename = "Location Details.pdf";
            $mpdf->Output($filename, 'D');
        } catch (Exception $ex) {

            report($ex);
        }
    }

    public function list(Request $request)
    {

        $conpanyId = decryptId($request->companyId);

        $Location = $this->location->ajaxList($conpanyId);

        return response()->json($Location);
    }
}
