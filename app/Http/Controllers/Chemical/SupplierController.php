<?php

namespace App\Http\Controllers\Chemical;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\SimpleExcel\SimpleExcelWriter;
use Illuminate\Support\Facades\Auth;

use PDF;
use Session;
use Exception;
use DataTables;


use App\Models\User;

use App\Models\Chemical\Supplier;


class SupplierController extends Controller
{

    private $supplier;
    private $user;

    public function __construct()
    {

        $this->supplier = new Supplier();
        $this->user = new User();
    }

    public function index(Request $request)
    {

        if (Auth::check()) {
            if ($request->ajax()) {
                try {

                    $data =  $this->supplier->list();

                    $datatables = Datatables::of($data['data'])
                        ->addIndexColumn()
                        ->addColumn('action', function ($row) {
                            $btn = '';
                            $btn .= '<a href="' . admin_url('chemical/master/supplier/edit/' . encryptId($row->id)) . '" class="popupwindow" title="Edit"><i class="fa-solid fa-pen-to-square"></i> ';
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

        return view('chemical.master.supplier.list', $data);
    }


    public function Add(Request $request)
    {

        try {

            $data = array();
            return view('chemical.master.supplier.add', $data);
        } catch (Exception $ex) {
            report($ex);
        }
    }

    public function Store(Request $request)
    {
        try {

            $rules = [
                'supplier_name' => 'required',
            ];
            $messages = [
                'supplier_name.required' => 'Please enter Supplier name',

            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                Session::flash('error', 'Something went wrong, Please try after sometimes!');
                return redirect()->back()->withErrors($validator)->withInput();
            }

            try {

                $this->supplier->store();

                Session::flash('success', 'Supplier added successfully!');
            } catch (Exception $ex) {


                Session::flash('error', 'Something went wrong, Please try after sometimes!');
            }

            return redirect(admin_url('chemical/master/supplier/list'));
        } catch (Exception $ex) {


            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('chemical/master/supplier/list'));
        }
    }

    public function Edit(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $supplier = $this->supplier->selectOne($id);

            $data = array(
                'supplier' => $supplier,
            );

            return view('chemical.master.supplier.edit', $data);
        } catch (Exception $error) {
            report($error->getMessage());
        }
    }

    public function Update(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $rules = [
                'supplier_name' => 'required',
            ];
            $messages = [
                'supplier_name.required' => 'Please enter Supplier name',

            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                Session::flash('error', 'Something went wrong, Please try after sometimes!');
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $this->supplier->updates($id);

            Session::flash('success', 'Supplier updated successfully!');
            return redirect(admin_url('chemical/master/supplier/list'));
        } catch (Exception $ex) {

            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('chemical/master/supplier/list'));
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

            $this->supplier->statuschange($id);

            return response()->json(['status' => 'success', 'msg' => 'Machinery Type status changed'], 200);
        } catch (Exception $ex) {

            return response()->json(['status' => 'error', 'msg' => 'Please try after some time'], 406);
        }
    }

    public function Delete(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $this->supplier->deleterecord($id);

            return response()->json(['status' => 'success', 'msg' => 'Machinery Type deleted successfully'], 200);
        } catch (Exception $ex) {

            return response()->json(['status' => 'error', 'msg' => 'Please try after some time'], 406);
        }
    }

    public function ExportExcel(Request $request)
    {

        try {

            $allData = $this->supplier->exportdata();

            $header = [
                'No.',
                'Supplier Name',
                'Address',
                'Contact Number',
                'Email ID',
                'Created Date',
            ];

            $i = 1;
            foreach ($allData as $data) {

                $export = [];
                $export['No.'] =  $i;
                $export['Supplier Name'] =  $data->supplier_name;
                $export['Address'] =  $data->address;
                $export['Contact Number'] =  $data->contact_no;
                $export['Email ID'] =  $data->email_id;
                $export['Created Date'] =  Displaydateformat($data->created_at);

                $exportData[] = $export;

                $i++;
            }

            $writer = SimpleExcelWriter::streamDownload('Chemical Supplier.xlsx')
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

            $allData = $this->supplier->exportdata();

            $header = [
                'No.',
                'Supplier Name',
                'Address',
                'Contact Number',
                'Email ID',
                'Created Date',
            ];

            $data = array(
                'header' => $header,
                'content' => $allData,
                'pagetitle' => "Supplier Details",
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

            $view = view('chemical.master.supplier.pdf', $data);
            $html = $view->render();



            $mpdf->WriteHTML($html);

            $filename = "Chemical Supplier.pdf";
            $mpdf->Output($filename, 'D');
        } catch (Exception $ex) {

            report($ex);
        }
    }
}
