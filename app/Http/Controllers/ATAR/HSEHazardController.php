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

use App\Models\ATAR\AtarTypes;
use App\Models\ATAR\ZefaRules;
use App\Models\ATAR\HSEHazard;


class HSEHazardController extends Controller
{

    private $atartype;
    private $zafarules;
    private $hsehazard;
    private $user;

    public function __construct()
    {

        $this->atartype = new AtarTypes();
        $this->zafarules = new ZefaRules();
        $this->hsehazard = new HSEHazard();
        $this->user = new User();
    }

    public function index(Request $request)
    {

        if (Auth::check()) {
            if ($request->ajax()) {
                try {

                    $data =  $this->hsehazard->list();

                    $datatables = Datatables::of($data['data'])
                        ->addIndexColumn()
                        ->addColumn('action', function ($row) {
                            $btn = '';
                            $btn .= '<a href="' . admin_url('atar/master/hsehazard/edit/' . encryptId($row->id)) . '" class="popupwindow" title="Edit"><i class="fa-solid fa-pen-to-square"></i> ';
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

        return view('atar.master.hsehazard.list', $data);
    }


    public function Add(Request $request)
    {

        try {

            $atarDetails =  $this->atartype->get();
            $zefaDetails =  $this->zafarules->get();

            $data = array(
                'atarDetails' =>  $atarDetails,
                'zefaDetails' =>  $zefaDetails,
            );
            return view('atar.master.hsehazard.add', $data);
        } catch (Exception $ex) {

            report($ex);
        }
    }

    public function Store(Request $request)
    {
        try {

            $rules = [
                'atar_type' => 'required',
                'zefa_rule' => 'required',
                'hse_hazard' => 'required',
                'atar_type' => 'required',
            ];
            $messages = [
                'atar_type.required' => 'Please select ATAR Type',
                'zefa_rule.required' => 'Please select ZeFA Rule',
                'hse_hazard.required' => 'Please enter HSE Hazard',
                'hover_message.required' => 'Please enter Message',

            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                Session::flash('error', 'Something went wrong, Please try after sometimes!');
                return redirect()->back()->withErrors($validator)->withInput();
            }

            try {

                $this->hsehazard->store();

                Session::flash('success', 'HSE Hazard added successfully!');
            } catch (Exception $ex) {


                Session::flash('error', 'Something went wrong, Please try after sometimes!');
            }

            return redirect(admin_url('atar/master/hsehazard/list'));
        } catch (Exception $ex) {


            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('atar/master/hsehazard/list'));
        }
    }

    public function Edit(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $atarDetails =  $this->atartype->get();
            $zefaDetails =  $this->zafarules->get();
            $hsehazard = $this->hsehazard->selectOne($id);

            $data = array(
                'atarDetails' =>  $atarDetails,
                'zefaDetails' =>  $zefaDetails,
                'hsehazard' =>  $hsehazard,
            );


            return view('atar.master.hsehazard.edit', $data);
        } catch (Exception $error) {
            report($error->getMessage());
        }
    }

    public function Update(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $rules = [
                'atar_type' => 'required',
                'zefa_rule' => 'required',
                'hse_hazard' => 'required',
                'atar_type' => 'required',
            ];
            $messages = [
                'atar_type.required' => 'Please select ATAR Type',
                'zefa_rule.required' => 'Please select ZeFA Rule',
                'hse_hazard.required' => 'Please enter HSE Hazard',
                'hover_message.required' => 'Please enter Message',

            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                Session::flash('error', 'Something went wrong, Please try after sometimes!');
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $this->hsehazard->updates($id);

            Session::flash('success', 'HSE Hazard updated successfully!');
            return redirect(admin_url('atar/master/hsehazard/list'));
        } catch (Exception $ex) {

            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('atar/master/hsehazard/list'));
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

            $this->hsehazard->statuschange($id);

            return response()->json(['status' => 'success', 'msg' => 'HSE Hazard status changed'], 200);
        } catch (Exception $ex) {

            return response()->json(['status' => 'error', 'msg' => 'Please try after some time'], 406);
        }
    }

    public function Delete(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $this->hsehazard->deleterecord($id);

            return response()->json(['status' => 'success', 'msg' => 'HSE Hazard deleted successfully'], 200);
        } catch (Exception $ex) {

            return response()->json(['status' => 'error', 'msg' => 'Please try after some time'], 406);
        }
    }

    public function ExportExcel(Request $request)
    {

        try {

            $allData = $this->hsehazard->exportdata();

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

            $allData = $this->hsehazard->exportdata();

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

            $view = view('atar.master.hsehazard.pdf', $data);
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

        $hsehazard = $this->hsehazard->ajaxList($useeId);

        return response()->json($hsehazard);

    }
}
