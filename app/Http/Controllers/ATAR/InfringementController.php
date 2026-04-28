<?php

namespace App\Http\Controllers\ATAR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\SimpleExcel\SimpleExcelWriter;

use PDF;
use Illuminate\Support\Facades\Auth;
use Session;
use Exception;
use DataTables;


use App\Models\User;

use App\Models\ATAR\Infringement;


class InfringementController extends Controller
{


    private $infringement;
    private $user;

    public function __construct()
    {


        $this->infringement = new Infringement();
        $this->user = new User();
    }

    public function index(Request $request)
    {

        if (Auth::check()) {
            if ($request->ajax()) {
                try {

                    $data =  $this->infringement->list();

                    $datatables = Datatables::of($data['data'])
                        ->addIndexColumn()
                        ->addColumn('action', function ($row) {
                            $btn = '';
                            $btn .= '<a href="' . admin_url('atar/master/infringement/edit/' . encryptId($row->id)) . '" class="popupwindow" title="Edit"><i class="fa-solid fa-pen-to-square"></i> ';
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

        return view('atar.master.infringement.list', $data);
    }


    public function Add(Request $request)
    {

        try {

            $data = array(

            );
            return view('atar.master.infringement.add', $data);
        } catch (Exception $ex) {

            report($ex);
        }
    }

    public function Store(Request $request)
    {
        try {

            $rules = [
                'type_of_infringement' => 'required',
                'infringement_no' => 'required',
            ];
            $messages = [
                'type_of_infringement.required' => 'Please select ATAR Type',
                'infringement_no.required' => 'Please select ZeFA Rule',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                Session::flash('error', 'Something went wrong, Please try after sometimes!');
                return redirect()->back()->withErrors($validator)->withInput();
            }

            try {

                $this->infringement->store();

                Session::flash('success', 'Infringement added successfully!');
            } catch (Exception $ex) {


                Session::flash('error', 'Something went wrong, Please try after sometimes!');
            }

            return redirect(admin_url('atar/master/infringement/list'));
        } catch (Exception $ex) {


            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('atar/master/infringement/list'));
        }
    }

    public function Edit(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $infringement = $this->infringement->selectOne($id);

            $data = array(
                'infringement' =>  $infringement,
            );


            return view('atar.master.infringement.edit', $data);
        } catch (Exception $error) {
            report($error->getMessage());
        }
    }

    public function Update(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $rules = [
                'type_of_infringement' => 'required',
                'infringement_no' => 'required',
            ];
            $messages = [
                'type_of_infringement.required' => 'Please select ATAR Type',
                'infringement_no.required' => 'Please select ZeFA Rule',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                Session::flash('error', 'Something went wrong, Please try after sometimes!');
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $this->infringement->updates($id);

            Session::flash('success', 'Infringement updated successfully!');
            return redirect(admin_url('atar/master/infringement/list'));
        } catch (Exception $ex) {

            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('atar/master/infringement/list'));
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

            $this->infringement->statuschange($id);

            return response()->json(['status' => 'success', 'msg' => 'Infringement status changed'], 200);
        } catch (Exception $ex) {

            return response()->json(['status' => 'error', 'msg' => 'Please try after some time'], 406);
        }
    }

    public function Delete(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $this->infringement->deleterecord($id);

            return response()->json(['status' => 'success', 'msg' => 'Infringement deleted successfully'], 200);
        } catch (Exception $ex) {

            return response()->json(['status' => 'error', 'msg' => 'Please try after some time'], 406);
        }
    }

    public function ExportExcel(Request $request)
    {

        try {

            $allData = $this->infringement->exportdata();

            $header = [
                'No.',
                'ATAR Type',
                'HSE Issues',
                'Message',
                'ZeFA Rule',
                'Created Date',
            ];

            $i = 1;
            foreach ($allData as $data) {

                $export = [];
                $export['No.'] =  $i;
                $export['ATAR Type'] =  $data->atar_type;
                $export['HSE Issues'] =  $data->hse_hazard;
                $export['Message'] =  $data->hover_msg;
                $export['ZeFA Rule'] =  $data->zefa_rule;
                $export['Created Date'] =  Displaydateformat($data->created_at);

                $exportData[] = $export;

                $i++;
            }

            $writer = SimpleExcelWriter::streamDownload('HSE Issues.xlsx')
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

            $allData = $this->infringement->exportdata();

            $header = [
                'No.',
                'ATAR Type',
                'HSE Issues',
                'Message',
                'ZeFA Rule',
                'Created Date',
            ];

            $data = array(
                'header' => $header,
                'content' => $allData,
                'pagetitle' => "HSE Issues",
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

            $view = view('atar.master.infringement.pdf', $data);
            $html = $view->render();



            $mpdf->WriteHTML($html);

            $filename = "HSE Issues.pdf";
            $mpdf->Output($filename, 'D');
        } catch (Exception $ex) {

            report($ex);
        }
    }

    public function list(Request $request){

        $useeId = decryptId($request->useeId);

        $hsehazard = $this->infringement->ajaxList($useeId);

        return response()->json($hsehazard);

    }
}
