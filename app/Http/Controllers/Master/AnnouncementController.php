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
use App\Models\Master\Announcement;



class AnnouncementController extends Controller
{

    private $announcement;

    public function __construct()
    {

        $this->announcement = new Announcement();
    }


    public function index(Request $request)
    {

        if (Auth::check()) {
            if ($request->ajax()) {
                try {

                    $data =  $this->announcement->list();

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
                            $btn = '<a href="' . admin_url('settings/announcement/view/' . encryptId($row->id)) . '"   class="" title="View"><i class="fa-solid fa-eye"></i></a> ';
                            $btn .= '<a href="' . admin_url('settings/announcement/edit/' . encryptId($row->id)) . '" class=" " title="Edit"><i class="fa-solid fa-pen-to-square"></i> ';
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

        return view('master.announcement.list', $data);
    }

    public function Add(Request $request)
    {

        try {

            $data = array();
            return view('master.announcement.add', $data);
        } catch (Exception $ex) {
            report($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('settings/announcement/list'));
        }
    }

    public function Store(Request $request)
    {
        try {

            $rules = [
                'announcement_id' => 'required',
                'announcement_title' => 'required',
                'announcement_content' => 'required',
            ];
            $messages = [
                'announcement_id.required' => 'Please enter announcement ID',
                'announcement_title.required' => 'Please enter announcement Name',
                'announcement_content.required' => 'Please enter announcement Short Name',

            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }


            $this->announcement->store();

            Session::flash('success', 'Announcement added successfully!');

            return redirect(admin_url('settings/announcement/list'));
        } catch (Exception $ex) {
            report($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('settings/announcement/list'));
        }
    }

    public function View(Request $request)
    {
        try {
            $id = decryptId($request->id);
            if (Auth::check()) {
                $announcement = $this->announcement->selectOne($id);

                $data = array(
                    'announcement' => $announcement,
                );
            }
            return view('master.announcement.view', $data);
        } catch (Exception $ex) {
            report($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('settings/announcement/list'));
        }
    }

    public function Edit(Request $request)
    {
        try {
            $id = decryptId($request->id);


            $announcement = $this->announcement->selectOne($id);
            $data = array(
                'announcement' => $announcement,
            );


            return view('master.announcement.edit', $data);
        } catch (Exception $ex) {
            report($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('settings/announcement/list'));
        }
    }

    public function Update(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $rules = [
                'announcement_id' => 'required',
                'announcement_title' => 'required',
                'announcement_content' => 'required',
            ];
            $messages = [
                'announcement_id.required' => 'Please enter announcement ID',
                'announcement_title.required' => 'Please enter announcement Name',
                'announcement_content.required' => 'Please enter announcement Short Name',

            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $this->announcement->updates($id);

            Session::flash('success', 'Announcement updated successfully!');
            return redirect(admin_url('settings/announcement/list'));
        } catch (Exception $ex) {

            report($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('settings/announcement/list'));
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

    public function StatusChange(Request $request)
    {

        try {
            $id = decryptId($request->id);

            $this->announcement->statuschange($id);

            return response()->json(['status' => 'success', 'msg' => 'Announcement status changed'], 200);
        } catch (Exception $ex) {

            return response()->json(['status' => 'error', 'msg' => 'Please try after some time'], 406);
        }
    }

    public function Delete(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $this->announcement->deleterecord($id);

            return response()->json(['status' => 'success', 'msg' => 'Announcement deleted successfully'], 200);
        } catch (Exception $ex) {

            return response()->json(['status' => 'error', 'msg' => 'Please try after some time'], 406);
        }
    }



    public function ExportExcel(Request $request)
    {

        try {

            $allData = $this->announcement->exportdata();

            $header = [
                'No.',
                'Announcement ID',
                'Announcement Title',
                'Announcement Contenet',
                'Status',
                'Created Date',
            ];

            $i = 1;
            foreach ($allData as $data) {

                $export = [];
                $export['No.'] =  $i;
                $export['announcement ID'] =  $data->announcement_id;
                $export['announcement Name'] =  $data->announcement_title;
                $export['announcement Short Name'] =  $data->announcement_content;

                $export['Location Status'] =  $data->status == 1 ? 'Active' : 'In-Active';
                $export['Created Date'] =  Displaydateformat($data->created_at);

                $exportData[] = $export;

                $i++;
            }

            $writer = SimpleExcelWriter::streamDownload('announcement.xlsx')
                ->addHeader($header)
                ->addRows(
                    $exportData
                );
        } catch (Exception $ex) {

            report($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('settings/announcement/list'));
        }
    }

    public function ExportPdf(Request $request)
    {

        try {

            $allData = $this->announcement->exportdata();

            $header = [
                'No.',
                'Announcement ID',
                'Announcement Title',
                'Announcement Contenet',
                'Status',
                'Created Date',
            ];

            $data = array(
                'header' => $header,
                'content' => $allData,
                'pagetitle' => "Announcement Details",
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

            $view = view('master.announcement.pdf', $data);
            $html = $view->render();



            $mpdf->WriteHTML($html);

            $filename = "announcement.pdf";
            $mpdf->Output($filename, 'D');
        } catch (Exception $ex) {

            report($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('settings/announcement/list'));
        }
    }
}
