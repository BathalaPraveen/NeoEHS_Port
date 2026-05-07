<?php

namespace App\Http\Controllers\WasteManagement;

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
use App\Models\WasteManagement\WasteCompany;


class WasteCompanyController extends Controller
{

    private $company;

    public function __construct()
    {

        $this->company = new WasteCompany();
    }

    public function index(Request $request)
    {
        if (Auth::check()) {
            if ($request->ajax()) {
                try {

                    $data =  $this->company->list();

                    $datatables = Datatables::of($data['data'])
                        ->addIndexColumn()

                        ->addColumn('action', function ($row) {
                            $btn = '';
                            $btn .= '<a href="' . admin_url('wastemanagement/master/company/edit/' . encryptId($row->id)) . '" class="popupwindow" title="Edit"><i class="fa-solid fa-pen-to-square"></i> ';
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

                    return response()->json(['status' => 'error', 'msg' => 'Please try after some time',$ex], 406);
                }
            }
        }

        $data = array();

        return view('wastemanagement.master.company.list', $data);
    }

    public function Add(Request $request)
    {

        try {

            $data = array();

            return view('wastemanagement.master.company.add', $data);

        } catch (Exception $ex) {
            report($ex);
        }
    }

    public function Store(Request $request)
    {

        try {

            $rules = [
                'company_name' => 'required',
                'company_address' => 'required',
                'person_incharge' =>  'required',
                'contact_no' =>  'required',
                'email' =>  'required',
            ];
            $messages = [
                'company_name.required' => 'Please enter company Name',
                'company_address.required' => 'Please enter the address',
                'person_incharge.required' => 'Please enter Person in Charge',
                'contact_no' => 'Please enter Contact No.',
                'email' => 'Please enter email',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                Session::flash('error', 'Something went wrong, Please try after sometimes!');
                return redirect()->back()->withErrors($validator)->withInput();
            }

            try {

                $this->company->store();

                Session::flash('success', 'Waste company added successfully!');
            } catch (Exception $ex) {


                Session::flash('error', 'Something went wrong, Please try after sometimes!');
            }

            return redirect(admin_url('wastemanagement/master/company/list'));
        } catch (Exception $ex) {


            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('wastemanagement/master/company/list'));
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
            return view('wastemanagement.master.company.view', $data);
        } catch (Exception $ex) {
            report($ex);
        }
    }

    public function Edit(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $company = $this->company->find($id);
            $data = array(
                'company' => $company,

            );


            return view('wastemanagement.master.company.edit', $data);
        } catch (Exception $error) {
            report($error->getMessage());
        }
    }

    public function Update(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $rules = [
                'company_name' => 'required',
                'company_address' => 'required',
                'person_incharge' =>  'required',
                'contact_no' =>  'required',
                'email' =>  'required',
            ];
            $messages = [
                'company_name.required' => 'Please enter company Name',
                'company_address.required' => 'Please enter the address',
                'person_incharge.required' => 'Please enter Person in Charge',
                'contact_no' => 'Please enter Contact No.',
                'email' => 'Please enter email',
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                Session::flash('error', 'Something went wrong, Please try after sometimes!');
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $this->company->updates($id);

            Session::flash('success', 'Waste company updated successfully!');
            return redirect(admin_url('wastemanagement/master/company/list'));
        } catch (Exception $ex) {
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('wastemanagement/master/company/list'));
        }
    }


    public function Delete(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $this->company->deleterecord($id);

            return response()->json(['status' => 'success', 'msg' => 'Waste company deleted successfully'], 200);
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
                'Company Name',
                'Company Address',
                'Person in Charge',
                'Contact No.',
                'Email',
                'Created Date',
            ];

            $i = 1;
            foreach ($allData as $data) {

                $export = [];
                $export['No.'] =  $i;
                $export['Company Name'] =  $data->company_name;
                $export['Company Address'] =  $data->company_address;
                $export['Person in Charge'] =  $data->person_incharge;
                $export['Contact No.'] =  $data->contact_no;
                $export['Email'] =  $data->email;
                $export['Created Date'] =  Displaydateformat($data->created_at);

                $exportData[] = $export;

                $i++;
            }

            $writer = SimpleExcelWriter::streamDownload('Waste Company.xlsx')
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

            $allData = $this->company->exportdata();

            $header = [
                'No.',
                'Company Name',
                'Company Address',
                'Person in Charge',
                'Contact No.',
                'Email',
                'Created Date',
            ];

            $data = array(
                'header' => $header,
                'content' => $allData,
                'pagetitle' => "Waste Company Details",
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

            $view = view('wastemanagement.master.company.pdf', $data);
            $html = $view->render();



            $mpdf->WriteHTML($html);

            $filename = "Waste Company.pdf";
            $mpdf->Output($filename, 'D');
        } catch (Exception $ex) {

            report($ex);
        }
    }

    public function list(Request $request){

        $categoryid = decryptId($request->categoryid);

        $category = $this->company->ajaxList($categoryid);

        return response()->json($category);

    }

}
