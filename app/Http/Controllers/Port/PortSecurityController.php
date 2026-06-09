<?php

namespace App\Http\Controllers\Port;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\SimpleExcel\SimpleExcelWriter;

use PDF;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

use App\Models\User;

use App\Models\Port\SecurityMaster;
use App\Models\Port\Cert_Security;

class PortSecurityController extends Controller
{

    private $securitymaster;
    private $certificate;

    public function __construct()
    {

        $this->securitymaster = new SecurityMaster();
        $this->certificate = new Cert_Security();
    }

    public function index(Request $request)
    {
        if (Auth::check()) {
            if ($request->ajax()) {
                try {
                    $data =  $this->securitymaster->list();
                    $datatables = Datatables::of($data['data'])
                        ->addIndexColumn()
                        ->addColumn('action', function ($row) {
                            $btn = '';
                            $btn = '<a href="' . admin_url('portsecurity/security_access/view/' . encryptId($row->id)) . '"   class="" title="View"><i class="fa-solid fa-eye"></i></a> ';
                            $btn .= '<a href="' . admin_url('portsecurity/security_access/vehicle_status/' . encryptId($row->id)) . '" class=" " title="Vehicle Status"><i class="fa-solid fa-pen-to-square"></i> ';
                            $btn .= '<a href="' . admin_url('portsecurity/security_access/pdf/' . encryptId($row->id)) . '" class=" " title="Pdf"><i class="fa fa-file-pdf-o"></i></a> ';
                            return $btn;
                        })
                        ->rawColumns(['action', 'created_date', 'created_by', 'status'])
                        ->setFilteredRecords($data['total_records'])
                        ->setTotalRecords($data['total_records'])
                        ->skipPaging()
                        ->make(true);
                    return $datatables;
                } catch (Exception $ex) {
                    dd( $ex);
                    return response()->json(['status' => 'error', 'msg' => 'Please try after some time'], 406);
                }
            }
        }
        $securitydata = $this->securitymaster->getall();
        $data = array(
             'securitydata' => $securitydata,
        );
        return view('port.security.list', $data);
    }

    public function View(Request $request)
    {
        try {
            $id = decryptId($request->id);
            if (Auth::check()) {
                $securitydata = $this->securitymaster->selectOne($id);
                $certifiactedata = $this->certificate->selectcerticatedata($id);
                $data = array(
                    'securitydata' => $securitydata,
                    'certifiactedata' => $certifiactedata,
                );
            }
            return view('port.security.view', $data);
        } catch (Exception $ex) {
            report($ex);
        }
    }

    public function VehicleStatus(Request $request)
    {
        try {
            $id = decryptId($request->id);
            if (Auth::check()) {
                $securitydata = $this->securitymaster->selectOne($id);
                $certifiactedata = $this->certificate->selectcerticatedata($id);
                $data = array(
                    'securitydata' => $securitydata,
                    'certifiactedata' => $certifiactedata,
                );
            }
            return view('port.security.vehicle_status', $data);
        } catch (Exception $ex) {
            report($ex);
        }
    }
    public function VehicleStatusAdd(Request $request)
    {
        try {
            $rules = [
                'vehicle_type'          => 'required',
                'vehicle_number'               => 'required',
            ];
            $messages = [
                'Vehicle Type.required'         => 'Please enter Vehicle Type',
                'vehicle_number.required'              => 'Please enter Vehicle Number',
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                Session::flash('error', 'Something went wrong, Please try after sometime!');
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            try {
                $id = $request->id;
                $this->securitymaster->VehicleStatusupdates($id);
                Session::flash('success', 'Port Security Access added successfully!');
            } catch (Exception $ex) {
                dd($ex);
                Session::flash('error', 'Something went wrong, Please try after sometimes!');
            }
            return redirect(admin_url('portsecurity/security_access/list'));
        } catch (Exception $ex) {
            dd($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('portsecurity/security_access/list'));
        }
    }

    public function ExportExcel(Request $request)
    {
        try {
            $allData = $this->securitymaster->exportdata();
            $header = [
                'No.',
                'PSS ID',
                'Name',
                'IC/Passport No',
                'Company Name',
                'Location Name',
                'Created Date',
            ];
            $i = 1;
            foreach ($allData as $data) {
                $export = [];
                $export['No.'] =  $i;
                $export['PSS ID'] =  $data->unique_id;
                $export['Name'] =  $data->name;
                $export['IC/Passport No'] =  $data->passport_number;
                $export['Company Name'] =  $data->company_name;
                $export['Location Name'] =  $data->location_name;
                $export['Created Date'] =  Displaydateformat($data->created_at);
                $exportData[] = $export;
                $i++;
            }
            $writer = SimpleExcelWriter::streamDownload('Port Security Access.xlsx')
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
            $allData = $this->securitymaster->exportdata();
            $header = [
                'No.',
                'PSS ID',
                'Name',
                'IC/Passport No',
                'Company Name',
                'Location Name',
                'Created Date',
            ];
            $data = array(
                'header' => $header,
                'content' => $allData,
                'pagetitle' => "Port Security Access Details",
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
            $view = view('port.security.pdf', $data);
            $html = $view->render();
            $mpdf->WriteHTML($html);
            $filename = "Port Security Access.pdf";
            $mpdf->Output($filename, 'D');
        } catch (Exception $ex) {

            report($ex);
        }
    }

     public function ExportViewPdf(Request $request)
    {

        try {
            $id = decryptId($request->id);
            $securitydata = $this->securitymaster->selectOne($id);
            $certifiactedata = $this->certificate->selectcerticatedata($id);
            $data = array(
                'securitydata' => $securitydata,
                'certifiactedata' => $certifiactedata,
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
            $view = view('port.security.rowpdf', $data);
            $html = $view->render();
            $mpdf->WriteHTML($html);
            $filename = "Port Security Access - ". $securitydata->unique_id . ".pdf";
            $mpdf->Output($filename, 'D');
        } catch (Exception $ex) {
            report($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('inspection/inspection/list'));
        }
    }
}
