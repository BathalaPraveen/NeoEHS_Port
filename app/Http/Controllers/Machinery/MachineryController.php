<?php

namespace App\Http\Controllers\Machinery;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Spatie\SimpleExcel\SimpleExcelWriter;
use Spatie\ImageOptimizer\OptimizerChainFactory;


use PDF;
use Mail;
use Session;
use Exception;
use DataTables;


use App\Models\User;

use App\Models\Master\Company;
use App\Models\Master\Division;
use App\Models\Master\Department;

use App\Models\Master\Location;
use App\Models\Master\SpecificLocation;

use App\Models\Machinery\MachineryType;
use App\Models\Machinery\SupportingDocuments;
use App\Models\Machinery\ParticularsMachinery;

use App\Models\Machinery\Machinery;
use App\Models\Machinery\MachineryFile;
use App\Models\Machinery\MachineryStatus;
use App\Models\Machinery\MachineryStatusLog;

use App\Mail\Machinery\MachineryEmail;


class MachineryController extends Controller
{

    private $company;
    private $division;
    private $department;
    private $location;
    private $specificlocation;

    private $machinerytype;
    private $supportingdocuments;
    private $partucularmachinery;
    private $machinery;
    private $machineryfiles;
    private $status;
    private $statuslog;

    public function __construct()
    {

        $this->company = new Company();
        $this->division = new Division();
        $this->department = new Department();
        $this->location = new Location();
        $this->specificlocation = new SpecificLocation();

        $this->machinerytype = new MachineryType();
        $this->supportingdocuments = new SupportingDocuments();
        $this->partucularmachinery = new ParticularsMachinery();
        $this->machinery = new Machinery();
        $this->machineryfiles = new MachineryFile();

        $this->status =  new MachineryStatus();
        $this->statuslog =  new MachineryStatusLog();
    }

    public function index(Request $request)
    {

        if (Auth::check()) {
            if ($request->ajax()) {
                try {

                    $data =  $this->machinery->list();

                    $datatables = Datatables::of($data['data'])
                        ->addIndexColumn()
                        ->addColumn('created_date', function ($row) {

                            return Displaydateformat($row->created_at);
                        })
                        ->addColumn('machinery_status', function ($row) {
                            $text = machhineryStatus($row->machinery_status);

                            return $text;
                        })
                        ->addColumn('action', function ($row) {
                            $btn = '';
                            $btn = '<a href="' . admin_url('machinery/machinery/view/' . encryptId($row->id)) . '" data-bs-toggle="tooltip" data-bs-original-title="View"  class="" title="View"><i class="fa-solid fa-eye"></i></a> ';
                            if ($row->machinery_status == MACHINERY_STATUS_GHSE_APPROVE_PENDING && (CheckUserRole(ROLE_GHSE_APPROVER) || isAdmin())) {
                                $btn .= '<a href="' . admin_url('machinery/machinery/approvereject/' . encryptId($row->id)) . '"   class="" title="Approve / Reject"><i class="fa-solid fa-check-to-slot"></i></a> ';
                            }
                            if ($row->machinery_status == MACHINERY_STATUS_HSE_INSP_PENDING && (CheckUserRole(ROLE_HSEUSER) || isAdmin())) {
                                $btn .= '<a href="' . admin_url('machinery/machinery/inspectionupdate/' . encryptId($row->id)) . '"   class="" title="inspection"><img style="width:20px;vertical-align: sub;" src="' . url('public/assets/images/icons/inspection.png') . '" alt="Approve/ Reject" ></a> ';
                            }
                            if (($row->machinery_status == MACHINERY_STATUS_GHSE_REJECTED ||  $row->machinery_status == MACHINERY_STATUS_HSE_INSP_REJECTED) && ($row->created_by == Auth::id() || isAdmin())) {
                                $btn .= '<a href="' . admin_url('machinery/machinery/edit/' . encryptId($row->id)) . '"   class="" title="Edit"><i class="fa-solid fa-edit"></i></a> ';
                            }
                            $btn .= '<a href="' . admin_url('machinery/machinery/view/pdf/' . encryptId($row->id)) . '" class=" " title="Pdf"><img style="width:20px;vertical-align: sub;" src="' . url('public/assets/images/icons/pdf.png') . '" alt="PDF" ></a> ';
                            return $btn;
                        })
                        ->rawColumns(['action', 'created_date', 'created_by', 'machinery_status'])
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

        $locationDetails = $this->location->get();
        $machinerytypeDetails = $this->machinerytype->get();
        $status = $this->status->get();


        $data = array(
            'locationDetails' => $locationDetails,
            'machinerytypeDetails' => $machinerytypeDetails,
            'statusDetails' => $status,
        );

        return view('machinery.machinery.list', $data);
    }

    public function Add(Request $request)
    {

        try {

            $locationDetails = $this->location->getAllLocation();
            $specificlocationDetails = $this->specificlocation->get();

            $machinerytypeDetails = $this->machinerytype->get();
            $supportingdocumentsDetails = $this->supportingdocuments->get();
            $partucularmachineryDetails = $this->partucularmachinery->get();


            $data = array(
                'locationDetails' => $locationDetails,
                'specificlocationDetails' => $specificlocationDetails,

                'machinerytypeDetails' => $machinerytypeDetails,
                'supportingdocumentsDetails' => $supportingdocumentsDetails,
                'partucularmachineryDetails' => $partucularmachineryDetails,

            );
            return view('machinery.machinery.add', $data);
        } catch (Exception $ex) {

            report($ex);
        }
    }

    public function Store(Request $request)
    {
        try {

            $rules = [
                'dateandtime' => 'required',
                'location' => 'required',
                'specific_location' => 'required',

            ];
            $messages = [
                'dateandtime.required' => 'Please enter Date & Time',
                'location.required' => 'Please select Location',
                'specific_location.required' => 'Please select Specific Location',

            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            try {

                $machinery =  $this->machinery->store();

                if ($machinery) {

                    $this->machineryfiles->store($machinery);


                    /**
                     * Send Email Notification
                     */

                    $email_id = 'gowtham.ardhas@gmail.com';

                    $mailsubject = 'New Machinery Details Added';



                    if ($email_id != '' || $email_id != null) {

                        $machinerydetails =  $this->machinery->selectOne($machinery->id);
                        $machineryArray  = $machinerydetails->toArray();


                        $machineryArray['name'] = 'Gowtham';
                        $machineryArray['email_id'] =  $email_id;
                        $machineryArray['mail_subject'] = $mailsubject;

                        Mail::to($machineryArray['email_id'])->queue(new MachineryEmail($machineryArray));
                    }


                    /**
                     * Send Web notification
                     */

                    $notificationData = array(
                        'notification_type' => 1,
                        'module_type' => 1,
                        'notification_message' => $mailsubject,
                        'mobile_notification' => json_encode(array(
                            'title' => $mailsubject,
                            'message' => 'New Machinery ' . $machinery->machinery_id . ' created by ' . getUsername($machinery->created_by),
                            'icon' => 'public/assets/images/notification/uauc.png',
                            'id' => $machinery->id,
                            'module' => 1,
                        )),
                        'web_link' =>  admin_url('machinery/machinery/view/' . encryptId($machinery->id)),
                        'assigned_user' => array_to_string([1]),
                        'created_by' => Auth::id(),
                    );
                    notificationSave($notificationData);

                    /**
                     * Send Mobile Push notification
                     */

                    $userId = [1];
                    $notifydata = [
                        'title' => $mailsubject,
                        'message' => 'New Machinery ' . $machinery->machinery_id . ' created by ' . getUsername($machinery->created_by),
                    ];
                    mobilePushNotification($userId, $notifydata);

                    Session::flash('success', 'Machinery added successfully!');
                } else {
                    Session::flash('error', 'Something went wrong, Please try after sometimes!');
                }
            } catch (Exception $ex) {


                Session::flash('error', 'Something went wrong, Please try after sometimes!');
            }


            return redirect(admin_url('machinery/machinery/list'));
        } catch (Exception $ex) {

            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('machinery/machinery/list'));
        }
    }

    public function View(Request $request)
    {
        try {

            $id = decryptId($request->id);

            $machineryDetails = $this->machinery->selectOne($id);
            $supportDocDetails = $this->machineryfiles->getWhere(['machinery_id' => $id]);

            $locationDetails = $this->location->get();
            $specificlocationDetails = $this->specificlocation->get();

            $machinerytypeDetails = $this->machinerytype->get();
            $supportingdocumentsDetails = $this->supportingdocuments->get();
            $partucularmachineryDetails = $this->partucularmachinery->get();
            $inspectionFiles = $this->machineryfiles->getWhereInspection(['machinery_id' => $id, 'type' => 2]);

            $statuslogs = $this->statuslog->getDetails($id);


            $data = array(
                'locationDetails' => $locationDetails,
                'specificlocationDetails' => $specificlocationDetails,

                'machinerytypeDetails' => $machinerytypeDetails,
                'supportingdocumentsDetails' => $supportingdocumentsDetails,
                'partucularmachineryDetails' => $partucularmachineryDetails,

                'machineryDetails' => $machineryDetails,
                'supportDocDetails' => $supportDocDetails,

                'inspectionFiles' => $inspectionFiles,
                'statuslogs' => $statuslogs,


            );
            return view('machinery.machinery.view', $data);
        } catch (Exception $ex) {


        }
    }


    public function ApproveReject(Request $request)
    {
        try {


            $id = decryptId($request->id);

            $machineryDetails = $this->machinery->selectOne($id);
            $supportDocDetails = $this->machineryfiles->getWhere(['machinery_id' => $id]);

            $locationDetails = $this->location->get();
            $specificlocationDetails = $this->specificlocation->get();

            $machinerytypeDetails = $this->machinerytype->get();
            $supportingdocumentsDetails = $this->supportingdocuments->get();
            $partucularmachineryDetails = $this->partucularmachinery->get();

            $statuslogs = $this->statuslog->getDetails($id);


            $data = array(
                'locationDetails' => $locationDetails,
                'specificlocationDetails' => $specificlocationDetails,

                'machinerytypeDetails' => $machinerytypeDetails,
                'supportingdocumentsDetails' => $supportingdocumentsDetails,
                'partucularmachineryDetails' => $partucularmachineryDetails,

                'machineryDetails' => $machineryDetails,
                'supportDocDetails' => $supportDocDetails,

                'statuslogs' => $statuslogs,

                'approvereject' => 'YES',
            );
            return view('machinery.machinery.view', $data);
        } catch (Exception $ex) {

            report($ex);
        }
    }

    public function ApproveRejectSubmit(Request $request)
    {

        try {

            $id = decryptId($request->id);
            $machinery = $this->machinery->find($id);

            if ($request->has('approve')) {
                $is_reject = 0;
                $status = MACHINERY_STATUS_HSE_INSP_PENDING;
            } else if ($request->has('reject')) {
                $is_reject = 1;
                $status = MACHINERY_STATUS_GHSE_REJECTED;
            }

            $machinery_id = $machinery->id;

            $insert_array = array(
                'machinery_id' => $machinery_id,
                'from_status' => 0,
                'to_status' => $status,
                'is_reject' => $is_reject,
                'remarks' => $request->remarks,
                'approved_by' => Auth::id(),
            );
            $this->statuslog->create($insert_array);

            $this->machinery->where('id', $id)->update(['machinery_status' => $status]);

            return redirect('machinery/machinery/list');
        } catch (Exception $ex) {
            report($ex);

        }
    }

    public function Inspection(Request $request)
    {
        try {


            $id = decryptId($request->id);

            $machineryDetails = $this->machinery->selectOne($id);
            $supportDocDetails = $this->machineryfiles->getWhere(['machinery_id' => $id, 'type' => 1]);
            $inspectionFiles = $this->machineryfiles->getWhereInspection(['machinery_id' => $id, 'type' => 2]);

            $locationDetails = $this->location->get();
            $specificlocationDetails = $this->specificlocation->get();

            $machinerytypeDetails = $this->machinerytype->get();
            $supportingdocumentsDetails = $this->supportingdocuments->get();
            $partucularmachineryDetails = $this->partucularmachinery->get();

            $statuslogs = $this->statuslog->getDetails($id);


            $data = array(
                'locationDetails' => $locationDetails,
                'specificlocationDetails' => $specificlocationDetails,

                'machinerytypeDetails' => $machinerytypeDetails,
                'supportingdocumentsDetails' => $supportingdocumentsDetails,
                'partucularmachineryDetails' => $partucularmachineryDetails,

                'machineryDetails' => $machineryDetails,
                'supportDocDetails' => $supportDocDetails,

                'inspectionFiles' => $inspectionFiles,

                'statuslogs' => $statuslogs,

                'inspection' => 'YES',
            );
            return view('machinery.machinery.view', $data);
        } catch (Exception $ex) {

            report($ex);
        }
    }

    public function InspectionSubmit(Request $request)
    {

        try {

            $id = decryptId($request->id);
            $machinery = $this->machinery->find($id);

            if ($request->has('approve')) {
                $is_reject = 0;
                $status = MACHINERY_STATUS_ACTIVE;
            } else if ($request->has('reject')) {
                $is_reject = 1;
                $status = MACHINERY_STATUS_HSE_INSP_REJECTED;
            }

            $machinery_id = $machinery->id;

            $insert_array = array(
                'machinery_id' => $machinery_id,
                'from_status' => MACHINERY_STATUS_HSE_INSP_PENDING,
                'to_status' => $status,
                'is_reject' => $is_reject,
                'remarks' => $request->remarks,
                'approved_by' => Auth::id(),
            );
            $this->statuslog->create($insert_array);

            $insp =  $this->machineryfiles->inspection($machinery);

            $currentDate = new \DateTime();

            $currentDate->add(new \DateInterval('P' . INSPECTION_EXPIRE . 'M'));
            $expiredate =  $currentDate->format('Y-m-d');

            $updateArray = [
                'machinery_status' => $status,
                'machinery_tag' => $request->machinerytag,
                'expiry_date' =>  $expiredate,
                'inspection_checklist' => $insp
            ];

            $this->machinery->where('id', $id)->update($updateArray);

            return redirect('machinery/machinery/list');
        } catch (Exception $ex) {
            report($ex);

        }
    }

    public function Edit(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $machineryDetails = $this->machinery->selectOne($id);
            $supportDocDetails = $this->machineryfiles->getWhere(['machinery_id' => $id]);

            $locationDetails = $this->location->getAllLocation();
            $specificlocationDetails = $this->specificlocation->get();

            $machinerytypeDetails = $this->machinerytype->get();
            $supportingdocumentsDetails = $this->supportingdocuments->get();
            $partucularmachineryDetails = $this->partucularmachinery->get();

            $inspectionFiles = $this->machineryfiles->getWhereInspection(['machinery_id' => $id, 'type' => 2]);
            $statuslogs = $this->statuslog->getDetails($id);

            $data = array(
                'locationDetails' => $locationDetails,
                'specificlocationDetails' => $specificlocationDetails,

                'machinerytypeDetails' => $machinerytypeDetails,
                'supportingdocumentsDetails' => $supportingdocumentsDetails,
                'partucularmachineryDetails' => $partucularmachineryDetails,

                'machineryDetails' => $machineryDetails,
                'supportDocDetails' => $supportDocDetails,

                'inspectionFiles' => $inspectionFiles,
                'statuslogs' => $statuslogs,


            );

            return view('machinery.machinery.edit', $data);
        } catch (Exception $error) {
            report($error->getMessage());
        }
    }

    public function Update(Request $request)
    {
        try {

            $id = decryptId($request->id);

            $rules = [
                'dateandtime' => 'required',
                'location' => 'required',
                'specific_location' => 'required',

            ];
            $messages = [
                'dateandtime.required' => 'Please enter Date & Time',
                'location.required' => 'Please select Location',
                'specific_location.required' => 'Please select Specific Location',

            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            try {

                $machinery_old = $this->machinery->find($id);
                $this->machinery->updates($id);
                $this->machineryfiles->updates($machinery_old);

                $machinery = $this->machinery->find($id);

                $insert_array = array(
                    'machinery_id' => $id,
                    'from_status' => $machinery_old->machinery_status,
                    'to_status' => $machinery->machinery_status,
                    'is_reject' => 0,
                    'remarks' => $request->remarks,
                    'approved_by' => Auth::id(),
                );
                $this->statuslog->create($insert_array);


                Session::flash('success', 'Machinery Updated successfully!');
            } catch (Exception $ex) {

                //
                Session::flash('error', 'Something went wrong, Please try after sometimes!');
            }

            return redirect(admin_url('machinery/machinery/list'));
        } catch (Exception $ex) {

            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('machinery/machinery/list'));
        }
    }

    public function Delete(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $this->machinery->deleterecord($id);

            return response()->json(['status' => 'success', 'msg' => 'Location deleted successfully'], 200);
        } catch (Exception $ex) {

            return response()->json(['status' => 'error', 'msg' => 'Please try after some time'], 406);
        }
    }

    public function ExportExcel(Request $request)
    {

        try {

            $allData = $this->machinery->exportdata();

            $header = [
                'No.',
                'Machinery ID',
                'Machinery Type',
                'Location',
                'Entry Tag ID',
                'Status',
                'Created By',
                'Created Date',
            ];


            $i = 1;
            foreach ($allData as $data) {

                $export = [];

                $export[] =  $i;
                $export[] =  $data->machinery_id;
                $export[] =  $data->machinery_type_name;
                $export[] =  $data->location_name;
                $export[] =  $data->machinery_tag;
                $export[] =  $data->status_name;
                $export[] =  getusername($data->created_by);
                $export[] =  Displaydateformat($data->created_at);

                $exportData[] = $export;

                $i++;
            }

            $writer = SimpleExcelWriter::streamDownload('Machinery List.xlsx')
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
            $allData = $this->machinery->exportdata();
            $header = [
                'No.',
                'Machinery ID',
                'Machinery Type',
                'Location',
                'Entry Tag ID',
                'Status',
                'Created By',
                'Created Date',
            ];

            $data = array(
                'header' => $header,
                'content' => $allData,
                'pagetitle' => "Machinery Details",
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

            $view = view('machinery.machinery.pdf', $data);
            $html = $view->render();


            $mpdf->WriteHTML($html);

            $filename = "Machinery List.pdf";
            $mpdf->Output($filename, 'D');
        } catch (Exception $ex) {

            report($ex);
        }
    }

    public function ExportViewPdf(Request $request)
    {

        try {

            $id = decryptId($request->id);

            $machineryDetails = $this->machinery->selectOne($id);

            $supportDocDetails = $this->machineryfiles->getWhere(['machinery_id' => $id]);

            $locationDetails = $this->location->get();
            $specificlocationDetails = $this->specificlocation->get();

            $machinerytypeDetails = $this->machinerytype->get();
            $supportingdocumentsDetails = $this->supportingdocuments->get();
            $partucularmachineryDetails = $this->partucularmachinery->get();
            $inspectionFiles = $this->machineryfiles->getWhereInspection(['machinery_id' => $id, 'type' => 2]);

            $statuslogs = $this->statuslog->getDetails($id);

            $userInfo = getuser($machineryDetails->created_by);
            $pagetitle = $machineryDetails->machinery_id;

            $data = array(
                'locationDetails' => $locationDetails,
                'specificlocationDetails' => $specificlocationDetails,

                'machinerytypeDetails' => $machinerytypeDetails,
                'supportingdocumentsDetails' => $supportingdocumentsDetails,
                'partucularmachineryDetails' => $partucularmachineryDetails,

                'machineryDetails' => $machineryDetails,
                'supportDocDetails' => $supportDocDetails,

                'inspectionFiles' => $inspectionFiles,
                'statuslogs' => $statuslogs,
                'userInfo' => $userInfo,
                'pagetitle' => $pagetitle,
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

            $view = view('machinery.machinery.pdf.machinery', $data);
            $html = $view->render();



            $mpdf->WriteHTML($html);

            $filename = $machineryDetails->machinery_id . ".pdf";
            $mpdf->Output($filename, 'D');
        } catch (Exception $ex) {

            report($ex);
        }
    }
}
