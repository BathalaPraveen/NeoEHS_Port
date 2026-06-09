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
use App\Models\Master\Company;
use App\Models\Master\Location;
use App\Models\Master\Designation;
use App\Models\User;

use App\Models\Port\SecurityMaster;
use App\Models\Port\Cert_Security;

class PortSecurityMasterController extends Controller
{

    private $securitymaster;
    private $securitycertificate;

    public function __construct()
    {

        $this->securitymaster = new SecurityMaster();
        $this->securitycertificate = new Cert_Security();
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
                            $btn = '<a href="' . admin_url('portsecurity/master/view/' . encryptId($row->id)) . '"   class="" title="View"><i class="fa-solid fa-eye"></i></a> ';
                            $btn .= '<a href="' . admin_url('portsecurity/master/edit/' . encryptId($row->id)) . '" class=" " title="Edit"><i class="fa-solid fa-pen-to-square"></i> ';
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
                    dd( $ex);
                    return response()->json(['status' => 'error', 'msg' => 'Please try after some time'], 406);
                }
            }
        }
        $securitydata = $this->securitymaster->getall();
        $data = array(
             'securitydata' => $securitydata,
        );
        return view('port.master.list', $data);
    }

    public function Add(Request $request)
    {
        try {
            $companyList =  Company::get();
            $designationList =  Designation::get();
            $data = array(
                'companyList' => $companyList,
                'designationList' => $designationList,
            );
            return view('port.master.add', $data);

        } catch (Exception $ex) {
            report($ex);
        }
    }

    public function Store(Request $request)
    {
        try {
            $rules = [
                'unique_id'          => 'required',
                'name'               => 'required',
                'id_type'            => 'required',
                'passport_number'    => 'required',
                'company_id'         => 'required',
                'location'           => 'required',
                'designation_id'     => 'required',
                'induction_date'     => 'required',
                'induction_duedate'  => 'required',

            ];
            $messages = [
                'unique_id.required'         => 'Please enter Unique ID',
                'name.required'              => 'Please enter Name',
                'id_type.required'           => 'Please select ID Type',
                'passport_number.required'   => 'Please enter IC/Passport No',
                'company_id.required'        => 'Please select Company',
                'location.required'          => 'Please select Location',
                'designation_id.required'    => 'Please select Designation',
                'induction_date.required'    => 'Please select Induction Date',
                'induction_duedate.required' => 'Please select Induction Due Date',

            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                Session::flash('error', 'Something went wrong, Please try after sometime!');
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            try {
                $id = $this->securitymaster->store();
                $this->securitycertificate->store($id);
                Session::flash('success', 'Port Security Access added successfully!');
            } catch (Exception $ex) {
                dd($ex);
                Session::flash('error', 'Something went wrong, Please try after sometimes!');
            }
            return redirect(admin_url('portsecurity/master/list'));
        } catch (Exception $ex) {
            dd($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('portsecurity/master/list'));
        }
    }

    public function View(Request $request)
    {
        try {
            $id = decryptId($request->id);
            if (Auth::check()) {
                $securitydata = $this->securitymaster->selectOne($id);
                $certifiactedata = $this->securitycertificate->selectcerticatedata($id);
                $data = array(
                    'securitydata' => $securitydata,
                    'certifiactedata' => $certifiactedata,
                );
            }
            return view('port.master.view', $data);
        } catch (Exception $ex) {
            report($ex);
        }
    }

    public function Edit($id)
    {
        try {
            $id = decryptId($id);
            $companyList     = Company::get();
            $designationList = Designation::get();
            $editData = $this->securitymaster->find($id);
            $competencyList = $this->securitycertificate->where('port_fk_id', $id)->get();
            $data = array(
                'companyList'     => $companyList,
                'designationList' => $designationList,
                'editData'        => $editData,
                'competencyList'  => $competencyList,
            );
            return view('port.master.edit', $data);
        } catch (Exception $ex) {
            dd($ex);
            report($ex);
        }
    }

    public function Update(Request $request)
    {
        try {
            $rules = [
                'unique_id'          => 'required',
                'name'               => 'required',
                'id_type'            => 'required',
                'passport_number'    => 'required',
                'company_id'         => 'required',
                'location'           => 'required',
                'designation_id'     => 'required',
                'induction_date'     => 'required',
                'induction_duedate'  => 'required',

            ];
            $messages = [
                'unique_id.required'         => 'Please enter Unique ID',
                'name.required'              => 'Please enter Name',
                'id_type.required'           => 'Please select ID Type',
                'passport_number.required'   => 'Please enter IC/Passport No',
                'company_id.required'        => 'Please select Company',
                'location.required'          => 'Please select Location',
                'designation_id.required'    => 'Please select Designation',
                'induction_date.required'    => 'Please select Induction Date',
                'induction_duedate.required' => 'Please select Induction Due Date',

            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                Session::flash('error', 'Something went wrong, Please try after sometime!');
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            $id = $request->edit_id;
            $this->securitymaster->updates($id);
            $this->securitycertificate->updates($id);
            Session::flash('success', 'Port Security Access updated successfully!');
            return redirect(admin_url('portsecurity/master/list'));
        } catch (Exception $ex) {
            dd($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('portsecurity/master/list'));
        }
    }

    public function deleteCertificate(Request $request)
    {
        try {
            $id = $request->id; // raw integer from blade

            $this->securitycertificate
                ->where('comp_cert_id', $id)
                ->update([
                    'status' => '0',
                    'trash'      => 'YES',
                    'updated_by' => Auth::id(),
                ]);

            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            report($e);
            return response()->json(['status' => 'error']);
        }
    }

    public function Delete(Request $request)
    {
        try {
            $id = decryptId($request->id);
            $this->securitymaster->deleterecord($id);
            return response()->json(['status' => 'success', 'msg' => 'Port Security Access deleted successfully'], 200);
        } catch (Exception $ex) {
            return response()->json(['status' => 'error', 'msg' => 'Please try after some time'], 406);
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
            $view = view('port.master.pdf', $data);
            $html = $view->render();
            $mpdf->WriteHTML($html);
            $filename = "Port Security Access.pdf";
            $mpdf->Output($filename, 'D');
        } catch (Exception $ex) {
            report($ex);
        }
    }
}
