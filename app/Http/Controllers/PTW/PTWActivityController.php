<?php

namespace App\Http\Controllers\PTW;

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

use App\Models\PTW\PTWActivity;


class PTWActivityController extends Controller
{

    private $ptwactivity;

    public function __construct()
    {

        $this->ptwactivity = new PTWActivity();
    }

    public function index(Request $request)
    {

        if (Auth::check()) {
            if ($request->ajax()) {
                try {

                    $data =  $this->ptwactivity->list();

                    $datatables = Datatables::of($data['data'])
                        ->addIndexColumn()
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

        return view('ptw.master.activity.list', $data);
    }

    public function Add(Request $request)
    {

        try {

            $locationDetails = Location::get();
            $data = array(
                'locationDetails' => $locationDetails
            );
            return view('ptw.master.activity.add', $data);
        } catch (Exception $ex) {
            report($ex);
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
                'company_id.required' => 'Please enter Location ID',
                'company_name.required' => 'Please enter Location Name',
                'company_shortname.required' => 'Please enter Specific Location Name',

            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            try {

                $this->ptwactivity->store();

                Session::flash('success', 'Specific Location added successfully!');
            } catch (Exception $ex) {


                Session::flash('error', 'Something went wrong, Please try after sometimes!');
            }

            return redirect(admin_url('company/list'));
        } catch (Exception $ex) {


            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('company/list'));
        }
    }

    public function View(Request $request)
    {
        try {
            $id = decryptId($request->id);
            if (Auth::check()) {
                $company = $this->ptwactivity->selectOne($id);

                $data = array(
                    'company' => $company,
                );
            }
            return view('ptw.master.activity.view', $data);
        } catch (Exception $ex) {
            report($ex);
        }
    }

    public function Edit(Request $request)
    {
        try {
            $id = decryptId($request->id);
            $locationDetails = Location::get();

            $company = $this->ptwactivity->selectOne($id);
            $data = array(
                'company' => $company,
            );


            return view('ptw.master.activity.edit', $data);
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
                'company_name' => 'required',
                'company_shortname' => 'required',
            ];
            $messages = [
                'company_id.required' => 'Please enter Location ID',
                'company_name.required' => 'Please enter Location Name',
                'company_shortname.required' => 'Please enter Specific Location Name',

            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $this->ptwactivity->updates($id);

            Session::flash('success', 'Location updated successfully!');
            return redirect(admin_url('company/list'));
        } catch (Exception $ex) {

            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('company/list'));
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

            $this->ptwactivity->statuschange($id);

            return response()->json(['status' => 'success', 'msg' => 'Location status changed'], 200);
        } catch (Exception $ex) {

            return response()->json(['status' => 'error', 'msg' => 'Please try after some time'], 406);
        }
    }

    public function Delete(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $this->ptwactivity->deleterecord($id);

            return response()->json(['status' => 'success', 'msg' => 'Location deleted successfully'], 200);
        } catch (Exception $ex) {

            return response()->json(['status' => 'error', 'msg' => 'Please try after some time'], 406);
        }
    }

    public function Import(Request $request)
    {
        $data = array();
        return view('admin.User_details_Import', $data);
    }

    public function ImportSubmit(Request $request)
    {
        try {
            $file = $request->file('user_file');
            if ($file != null) {
                $uploadpath = 'public/uploads/userdata';
                $filenewname = time() . Str::random('10') . '.' . $file->getClientOriginalExtension();
                $fileName = $file->getClientOriginalName();
                $fileSize = $file->getSize();
                $fileMimetype = $file->getMimeType();
                $fileExt = $file->getClientOriginalExtension();
                $file->move($uploadpath, $filenewname);
                $path = $uploadpath . "/" . $filenewname;
                $user_id = auth()->user()->id;
                $insert_data = array(
                    'file_path' => $path,
                    'source_path' => $path,
                    'dest-path' => $path,
                    'file_name' => $filenewname,
                    'file_orgname' => $fileName,
                    'extract_status' => 0,
                    'upload_type' => '2',
                    'created_by' => $user_id,
                );
                $insert_id = DB::table('admin_upload_log')->insertGetId($insert_data);
                $details = [
                    "user_id" => $user_id,
                    "log_id" => $insert_id,
                    "path" => $path,
                    "expire" => get_constant('RESET_PASSWORD_EXPIRE'),
                ];
                dispatch((new ImportUserJob($details))->onQueue('high'));
                // \Excel::import(new UserImport($user_id, $insert_id), $path);
            }
            $insert_data['log_id'] = $insert_id;
            $insert_data['Uploded_by'] = Auth::user()->toArray();
            Log::channel('user-info')->info("User Successfully Uploaded", $insert_data);
            Session::flash('success', 'Successfully User upload !');
            return redirect(admin_url('user_management'));
        } catch (Exception $ex) {
            Log::channel('user-info')->alert($ex);
            Session::flash('error', 'User upload failed!');
            return redirect(admin_url('user_management'));
        }
    }

    public function ExportExcel(Request $request)
    {

        try {

            $allData = $this->ptwactivity->exportdata();

            $header = [
                'No.',
                'Module Name',
                'Activity Name',
                'Created Date',
            ];

            $i = 1;
            foreach ($allData as $data) {

                $export = [];
                $export['No.'] =  $i;
                $export['Module Name'] =  $data->module;
                $export['Activity Name'] =  $data->activity_name;

                $export['Created Date'] =  Displaydateformat($data->created_at);

                $exportData[] = $export;

                $i++;
            }

            $writer = SimpleExcelWriter::streamDownload('PTW Activity.xlsx')
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

            $allData = $this->ptwactivity->exportdata();

            $header = [
                'No.',
                'Module Name',
                'Activity Name',
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

            $view = view('ptw.master.activity.pdf', $data);
            $html = $view->render();



            $mpdf->WriteHTML($html);

            $filename = "PTW Activity.pdf";
            $mpdf->Output($filename, 'D');
        } catch (Exception $ex) {

            report($ex);
        }
    }
}
