<?php

namespace App\Http\Controllers\Machinery;

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

use App\Models\Machinery\MachineryType;


class MachineryTypeController extends Controller
{

    private $machinerytype;
    private $user;

    public function __construct()
    {

        $this->machinerytype = new MachineryType();
        $this->user = new User();
    }

    public function index(Request $request)
    {

        if (Auth::check()) {
            if ($request->ajax()) {
                try {

                    $data =  $this->machinerytype->list();

                    $datatables = Datatables::of($data['data'])
                        ->addIndexColumn()
                        ->addColumn('action', function ($row) {
                            $btn = '';
                            $btn .= '<a href="' . admin_url('machinery/master/machinerytype/edit/' . encryptId($row->id)) . '" class="popupwindow" title="Edit"><i class="fa-solid fa-pen-to-square"></i> ';
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

        return view('machinery.master.machinerytype.list', $data);
    }


    public function Add(Request $request)
    {

        try {

            $data = array();
            return view('machinery.master.machinerytype.add', $data);
        } catch (Exception $ex) {
            report($ex);
        }
    }

    public function Store(Request $request)
    {
        try {

            $rules = [
                'machinery_type' => 'required',
            ];
            $messages = [
                'machinery_type.required' => 'Please enter Machinery type name',

            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                Session::flash('error', 'Something went wrong, Please try after sometimes!');
                return redirect()->back()->withErrors($validator)->withInput();
            }

            try {

                $this->machinerytype->store();

                Session::flash('success', 'Machinery Type added successfully!');
            } catch (Exception $ex) {


                Session::flash('error', 'Something went wrong, Please try after sometimes!');
            }

            return redirect(admin_url('machinery/master/machinerytype/list'));
        } catch (Exception $ex) {


            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('machinery/master/machinerytype/list'));
        }
    }

    public function Edit(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $machineryType = $this->machinerytype->selectOne($id);

            $data = array(
                'machineryType' => $machineryType,
            );

            return view('machinery.master.machinerytype.edit', $data);
        } catch (Exception $error) {
            report($error->getMessage());
        }
    }

    public function Update(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $rules = [
                'machinery_type' => 'required',
            ];
            $messages = [
                'machinery_type.required' => 'Please enter Machinery type name',

            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                Session::flash('error', 'Something went wrong, Please try after sometimes!');
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $this->machinerytype->updates($id);

            Session::flash('success', 'Machinery Type updated successfully!');
            return redirect(admin_url('machinery/master/machinerytype/list'));
        } catch (Exception $ex) {

            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('machinery/master/machinerytype/list'));
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

            $this->machinerytype->statuschange($id);

            return response()->json(['status' => 'success', 'msg' => 'Machinery Type status changed'], 200);
        } catch (Exception $ex) {

            return response()->json(['status' => 'error', 'msg' => 'Please try after some time'], 406);
        }
    }

    public function Delete(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $this->machinerytype->deleterecord($id);

            return response()->json(['status' => 'success', 'msg' => 'Machinery Type deleted successfully'], 200);
        } catch (Exception $ex) {

            return response()->json(['status' => 'error', 'msg' => 'Please try after some time'], 406);
        }
    }

    public function ExportExcel(Request $request)
    {

        try {

            $allData = $this->machinerytype->exportdata();

            $header = [
                'No.',
                'Machinery Type',
                'Machinery Description',
                'Created Date',
            ];

            $i = 1;
            foreach ($allData as $data) {

                $export = [];
                $export['No.'] =  $i;
                $export['Machinery Type'] =  $data->machinery_type;
                $export['Machinery Description'] =  $data->machinery_description;
                $export['Created Date'] =  Displaydateformat($data->created_at);

                $exportData[] = $export;

                $i++;
            }

            $writer = SimpleExcelWriter::streamDownload('Machinery Type.xlsx')
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

            $allData = $this->machinerytype->exportdata();

            $header = [
                'No.',
                'Machinery Type',
                'machinery_description',
                'Created Date',
            ];

            $data = array(
                'header' => $header,
                'content' => $allData,
                'pagetitle' => "Machinery Type",
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

            $view = view('machinery.master.machinerytype.pdf', $data);
            $html = $view->render();



            $mpdf->WriteHTML($html);

            $filename = "Machinery Type.pdf";
            $mpdf->Output($filename, 'D');
        } catch (Exception $ex) {

            report($ex);
        }
    }
}
