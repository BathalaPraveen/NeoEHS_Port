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

use Illuminate\Support\Facades\Response;
use App\Models\Master\Company;



class CompanyController extends Controller
{

    private $company;

    public function __construct()
    {

        $this->company = new Company();
    }


    public function index(Request $request)
    {

        if (Auth::check()) {
            if ($request->ajax()) {
                try {

                    $data =  $this->company->list();

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
                            $btn = '<a href="' . admin_url('company/view/' . encryptId($row->id)) . '"   class="" title="View"><i class="fa-solid fa-eye"></i></a> ';
                            $btn .= '<a href="' . admin_url('company/edit/' . encryptId($row->id)) . '" class=" " title="Edit"><i class="fa-solid fa-pen-to-square"></i> ';
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

        return view('master.company.list', $data);
    }

    public function Add(Request $request)
    {

        try {

            $data = array();
            return view('master.company.add', $data);
        } catch (Exception $ex) {
            report($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('company/list'));
        }
    }

    public function Store(Request $request)
    {
        try {

            $rules = [
                'company_id' => 'required',
                'company_name' => 'required',
                'company_shortname' => 'required',
            ];
            $messages = [
                'company_id.required' => 'Please enter Company ID',
                'company_name.required' => 'Please enter Company Name',
                'company_shortname.required' => 'Please enter Company Short Name',

            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }



            $this->company->store();

            Session::flash('success', 'Company added successfully!');
            return redirect(admin_url('company/list'));
        } catch (Exception $ex) {
            report($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('company/list'));
        }
    }

    public function View(Request $request)
    {
        try {
            $id = decryptId($request->id);
            if (Auth::check()) {
                $company = $this->company->selectOne($id);

                $data = array(
                    'company' => $company,
                );
            }
            return view('master.company.view', $data);
        } catch (Exception $ex) {
            report($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('company/list'));
        }
    }

    public function Edit(Request $request)
    {
        try {
            $id = decryptId($request->id);


            $company = $this->company->selectOne($id);
            $data = array(
                'company' => $company,
            );


            return view('master.company.edit', $data);
        } catch (Exception $ex) {
            report($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('company/list'));
        }
    }

    public function Update(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $rules = [
                'company_id' => 'required',
                'company_name' => 'required',
                'company_shortname' => 'required',
            ];
            $messages = [
                'company_id.required' => 'Please enter Company ID',
                'company_name.required' => 'Please enter Company Name',
                'company_shortname.required' => 'Please enter Company Short Name',
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $this->company->updates($id);

            Session::flash('success', 'Company updated successfully!');
            return redirect(admin_url('company/list'));
        } catch (Exception $ex) {

            report($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('company/list'));
        }
    }

    // public function Uniquecheck(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $email = $request->email;
    //         $userid = $request->userid;
    //         if ($userid == '') {
    //             $user = $this->user->EmailCheck($email);
    //         } else {
    //             $user = $this->user->ExistEmailCheck($email, $userid);
    //         }
    //         if ($user->count()) {
    //             return Response::json(array('msg' => 'true'));
    //         }
    //         return Response::json(array('msg' => 'false'));
    //     }
    // }

    public function ROCUniquecheck(Request $request)
    {
        if ($request->ajax()) {
            $id = decryptId($request->id);
            $roc_no = $request->roc_no;
            if ($id) {
                $rocExists = $this->company->ExistROCUniquecheck($id, $roc_no);
            } else {
                $rocExists = $this->company->ROCUniquecheck($roc_no);
            }

            return response($rocExists ? 'false' : 'true');
        }
    }

    public function StatusChange(Request $request)
    {

        try {
            $id = decryptId($request->id);

            $this->company->statuschange($id);

            return response()->json(['status' => 'success', 'msg' => 'Company status changed'], 200);
        } catch (Exception $ex) {

            return response()->json(['status' => 'error', 'msg' => 'Please try after some time'], 406);
        }
    }

    public function Delete(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $this->company->deleterecord($id);

            return response()->json(['status' => 'success', 'msg' => 'Company deleted successfully'], 200);
        } catch (Exception $ex) {

            return response()->json(['status' => 'error', 'msg' => 'Please try after some time'], 406);
        }
    }



    public function ExportExcel(Request $request)
    {

        try {

            $allData = $this->company->exportdata();

            $header = [
                'No.',
                'Company ID',
                'Company Name',
                'Company Short Name',
                'Location Status',
                'Created Date',
            ];

            $i = 1;
            foreach ($allData as $data) {

                $export = [];
                $export['No.'] =  $i;
                $export['Company ID'] =  $data->company_id;
                $export['Company Name'] =  $data->company_name;
                $export['Company Short Name'] =  $data->company_shortname;

                $export['Location Status'] =  $data->status == 1 ? 'Active' : 'In-Active';
                $export['Created Date'] =  Displaydateformat($data->created_at);

                $exportData[] = $export;

                $i++;
            }

            $writer = SimpleExcelWriter::streamDownload('Company.xlsx')
                ->addHeader($header)
                ->addRows(
                    $exportData
                );
        } catch (Exception $ex) {

            report($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('company/list'));
        }
    }

    public function ExportPdf(Request $request)
    {

        try {

            $allData = $this->company->exportdata();

            $header = [
                'No.',
                'Company ID',
                'Company Name',
                'Company Short Name',
                'Location Status',
                'Created Date',
            ];

            $data = array(
                'header' => $header,
                'content' => $allData,
                'pagetitle' => "Company Details",
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

            $view = view('master.company.pdf', $data);
            $html = $view->render();



            $mpdf->WriteHTML($html);

            $filename = "Company.pdf";
            $mpdf->Output($filename, 'D');
        } catch (Exception $ex) {

            report($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('company/list'));
        }
    }
}
