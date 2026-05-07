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
use App\Models\Master\Location;
use App\Models\Master\SpecificLocation;
use App\Models\User;

class SpecificLocationController extends Controller
{

    private $users;
    private $company;
    private $location;
    private $specificlocation;

    public function __construct()
    {
        $this->users = new User();
        $this->company = new Company();
        $this->location = new Location();
        $this->specificlocation = new SpecificLocation();
    }

    public function index(Request $request)
    {

        if (Auth::check()) {
            if ($request->ajax()) {
                try {

                    $data =  $this->specificlocation->list();

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
                            $btn = '<a href="' . admin_url('specificlocation/view/' . encryptId($row->id)) . '"   class="" title="View"><i class="fa-solid fa-eye"></i></a> ';
                            $btn .= '<a href="' . admin_url('specificlocation/edit/' . encryptId($row->id)) . '" class=" " title="Edit"><i class="fa-solid fa-pen-to-square"></i> ';
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

        return view('master.specificlocation.list', $data);
    }

    public function Add(Request $request)
    {

        try {

            $companyDetails =  $this->company->getAllCompany();
            $employeeDetails =  $this->users->getAllDataBasedRole(ROLE_AREA_OWNER);

            $data = array(
                'companyDetails' => $companyDetails,
                'employeeDetails' => $employeeDetails,
            );
            return view('master.specificlocation.add', $data);
        } catch (Exception $ex) {
            report($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('specificlocation/list'));
        }
    }

    public function Store(Request $request)
    {
        try {

            $rules = [
                'company_id' => 'required',
                'specific_location_id' => 'required',
                'location_id' => 'required',
                'specific_location_name' => 'required',

            ];
            $messages = [
                'company_id.required' => 'Please select the Company ID',
                'specific_location_id.required' => 'Please enter Location ID',
                'location_id.required' => 'Please enter Location Name',
                'specific_location_name.required' => 'Please enter Specific Location Name',


            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            try {

                $this->specificlocation->store();

                Session::flash('success', 'Specific Location added successfully!');
            } catch (Exception $ex) {

                report($ex);
                Session::flash('error', 'Something went wrong, Please try after sometimes!');
            }

            return redirect(admin_url('specificlocation/list'));
        } catch (Exception $ex) {

            report($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('specificlocation/list'));
        }
    }

    public function View(Request $request)
    {
        try {
            $id = decryptId($request->id);
            if (Auth::check()) {
                $location = $this->specificlocation->selectOne($id);

                $data = array(
                    'location' => $location,
                );
            }
            return view('master.specificlocation.view', $data);
        } catch (Exception $ex) {
            report($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('specificlocation/list'));
        }
    }

    public function Edit(Request $request)
    {
        try {
            $id = decryptId($request->id);
            $location = $this->specificlocation->selectOne($id);

            $locationDetails = $this->location->getcompany($location->company_id);
            $companyDetails =  $this->company->getAllCompany();
            $employeeDetails =  $this->users->getAllDataBasedRole(ROLE_AREA_OWNER);

            $data = array(
                'location' => $location,
                'locationDetails' => $locationDetails,
                'companyDetails' => $companyDetails,
                'employeeDetails' => $employeeDetails,
            );
            return view('master.specificlocation.edit', $data);
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
                'specific_location_name' => 'required',
                'specific_location_desc' => 'required',
            ];
            $messages = [
                'company_id.required' => 'Please select the Company ID',
                'location_id.required' => 'Please enter Location Name',
                'specific_location_name.required' => 'Please enter Specific Location Name',
                'specific_location_desc.required' => 'Please enter Specific Location Description',
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $this->specificlocation->updates($id);

            Session::flash('success', 'Location updated successfully!');
            return redirect(admin_url('specificlocation/list'));
        } catch (Exception $ex) {

            report($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('specificlocation/list'));
        }
    }


    public function StatusChange(Request $request)
    {

        try {
            $id = decryptId($request->id);

            $this->specificlocation->statuschange($id);

            return response()->json(['status' => 'success', 'msg' => 'Location status changed'], 200);
        } catch (Exception $ex) {

            return response()->json(['status' => 'error', 'msg' => 'Please try after some time'], 406);
        }
    }

    public function Delete(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $this->specificlocation->deleterecord($id);

            return response()->json(['status' => 'success', 'msg' => 'Location deleted successfully'], 200);
        } catch (Exception $ex) {

            return response()->json(['status' => 'error', 'msg' => 'Please try after some time'], 406);
        }
    }


    public function ExportExcel(Request $request)
    {

        try {

            $allData = $this->specificlocation->exportdata();

            $header = [
                'No.',
                'Company Name',
                'Location Name',
                'Specific Location ID',
                'Specific Location Name',
                'Specific Location Address / Description',
                'Status',
                'Created Date',
            ];

            $i = 1;
            foreach ($allData as $data) {

                $export = [];
                $export['No.'] =  $i;
                $export['Company Name'] =  $data->company_name;
                $export['Location Name'] =  $data->location_name;
                $export['Specific Location ID'] =  $data->specific_location_id;
                $export['Specific Location Name'] =  $data->specific_loc_name;
                $export['Specific Location Description'] =  $data->specific_loc_desc;
                $export['Location Status'] =  $data->status == 1 ? 'Active' : 'In-Active';
                $export['Created Date'] =  Displaydateformat($data->created_at);

                $exportData[] = $export;

                $i++;
            }

            $writer = SimpleExcelWriter::streamDownload('Specific Location.xlsx')
                ->addHeader($header)
                ->addRows(
                    $exportData
                );
        } catch (Exception $ex) {

            report($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('specificlocation/list'));
        }
    }

    public function ExportPdf(Request $request)
    {

        try {

            $allData = $this->specificlocation->exportdata();

            $header = [
                'No.',
                'Company Name',
                'Location Name',
                'Specific Location ID',
                'Specific Location Name',
                'Specific Location Address / Description',
                'Status',
                'Created Date',
            ];

            $data = array(
                'header' => $header,
                'content' => $allData,
                'pagetitle' => "Specific Location Details",
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

            $view = view('master.specificlocation.pdf', $data);
            $html = $view->render();


            $mpdf->WriteHTML($html);

            $filename = "Specific Location.pdf";
            $mpdf->Output($filename, 'D');
        } catch (Exception $ex) {

            report($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('specificlocation/list'));
        }
    }

    public function list(Request $request)
    {

        $locationId = decryptId($request->locationId);

        $specifiLocation = $this->specificlocation->ajaxList($locationId);

        return response()->json($specifiLocation);
    }

    public function getAreaOwner(Request $request)
    {

        $specificlocationId = decryptId($request->id);
        $area_owners = $this->specificlocation->selectOne($specificlocationId)->area_owner;
        $Location = $this->users->ajaxList($area_owners);

        return response()->json($Location);
    }
}
