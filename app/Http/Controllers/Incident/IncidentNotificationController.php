<?php

namespace App\Http\Controllers\Incident;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Spatie\SimpleExcel\SimpleExcelWriter;
use Spatie\ImageOptimizer\OptimizerChainFactory;


use PDF;
use Mail;
use Illuminate\Support\Facades\Session;
use Exception;
use Yajra\DataTables\Facades\DataTables;

use App\Models\User;

use App\Models\Master\Company;
use App\Models\Master\Division;
use App\Models\Master\Department;

use App\Models\Master\Location;
use App\Models\Master\SpecificLocation;

use App\Models\Incident\{
    IncidentCategory,
    IncidentItem,
    IncidentSubItem,
    IncidentClassification,
    IncidentNotification,
    IncidentNotificationCasualtyFatality,
    IncidentNotificationClassification,
    NotificationStatus,
    NotificationStatusLog,
    IncidentInvestigation
};



class IncidentNotificationController extends Controller
{

    private $company;
    private $division;
    private $department;
    private $location;
    private $specificlocation;

    private $category;
    private $item;
    private $subitem;
    private $classification;
    private $notification;
    private $notificationcasualtyfatality;
    private $notificationclassification;

    private $investgation;

    private $status;
    private $statuslog;


    public function __construct()
    {

        $this->company = new Company();
        $this->division = new Division();
        $this->department = new Department();
        $this->location = new Location();
        $this->specificlocation = new SpecificLocation();

        $this->category = new IncidentCategory();
        $this->item = new IncidentItem();
        $this->subitem = new IncidentSubItem();
        $this->classification = new IncidentClassification();
        $this->notification = new IncidentNotification();
        $this->notificationcasualtyfatality = new IncidentNotificationCasualtyFatality();
        $this->notificationclassification = new IncidentNotificationClassification();

        $this->status = new NotificationStatus();
        $this->statuslog = new NotificationStatusLog();

        $this->investgation = new IncidentInvestigation();
    }

    public function index(Request $request)
    {

        if (Auth::check()) {
            if ($request->ajax()) {
                try {

                    $data =  $this->notification->list();

                    $datatables = DataTables::of($data['data'])
                        ->addIndexColumn()
                        ->addColumn('incident_date', function ($row) {
                            return Displaydateformat($row->incident_date);
                        })
                        ->addColumn('incident_type', function ($row) {
                            return getIncidentTypeName($row->incident_type);
                        })

                        ->addColumn('created_user', function ($row) {
                            return getusername($row->created_by);
                        })
                        ->addColumn('location_name', function ($row) {
                            return getLocationName($row->location_id);
                        })
                        ->addColumn('incident_status', function ($row) {
                            $text = incidentStatus($row->incident_status);
                            return $text;
                        })
                        ->addColumn('action', function ($row) {
                            $btn = '';
                            $btn  = '<a href="' . admin_url('incident/notification/view/' . encryptId($row->id)) . '"   class="" title="View"><i class="fa-solid fa-eye"></i></a> ';

                            if ($row->incident_status == INCIDENT_NOTIFICATION_STATUS_GHSE_PENDING && (CheckUserRole(ROLE_SUPERADMIN) || CheckUserRole(ROLE_GHSE_APPROVER))) {
                                $btn .= '<a href="' . admin_url('incident/notification/approvereject/' . encryptId($row->id)) . '"   class="" title="Approve / Reject"><i class="fa-solid fa-check-to-slot"></i></a> ';
                            }

                            if ($row->incident_status == INCIDENT_NOTIFICATION_STATUS_GHSE_REJECTED && (CheckUserRole(ROLE_SUPERADMIN) || $row->created_by == Auth::id())) {
                                $btn .= '<a href="' . admin_url('incident/notification/edit/' . encryptId($row->id)) . '"   class="" title="Edit"><i class="fa-solid fa-edit"></i></a> ';
                            }

                            return $btn;
                        })
                        ->rawColumns(['action', 'created_date', 'created_by', 'incident_status'])
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
        $status = $this->status->get();
        $incidentId = $this->notification->getall();

        $data = array(
            'locationDetails' => $locationDetails,
            'statusDetails' => $status,
            'incidentId' => $incidentId,
            'incident_open_close_status' => $request->incident_open_close_status,
        );

        return view('incident.notification.list', $data);
    }

    public function Add(Request $request)
    {
        try {
            $companyDetails = $this->company->getAllCompany();
            $locationDetails = $this->location->getAllLocation();
            $specificlocationDetails = $this->specificlocation->getAllSpecificLocation();

            $emergencyincidenttireList = $this->item->getlist(EMERGENCY_INCIDENT_TIRE);
            $weatherconditionList = $this->item->getlist(WEATHER_CONDITION);
            $locationList = $this->item->getlist(LOCATION);
            $incidentpotentialList = $this->item->getlist(INCIDENT_POTENTIAL);
            $authoritiesinformList = $this->item->getlist(AUTHORITIES_INFORM);
            $incidentclassificationList = $this->item->getlist(INCIDENT_CLASSIFICATION);
            $typeofnotificationList = $this->item->getlist(TYPE_OF_NOTIFICATION);
            $categoryofincidentList = $this->item->getlist(CATEGORY_OF_INCIDENT);

            $subcategoryofincidentList = $this->subitem->getlist(CATEGORY_OF_INCIDENT);

            $classificationList = $this->classification->getList();

            $data = array(
                'companyDetails' => $companyDetails,
                'locationDetails' => $locationDetails,
                'specificlocationDetails' => $specificlocationDetails,
                'emergencyincidenttireList' => $emergencyincidenttireList,
                'weatherconditionList' => $weatherconditionList,
                'locationList' => $locationList,
                'incidentpotentialList' => $incidentpotentialList,
                'authoritiesinformList' => $authoritiesinformList,
                'incidentclassificationList' => $incidentclassificationList,
                'typeofnotificationList' => $typeofnotificationList,
                'categoryofincidentList' => $categoryofincidentList,
                'subcategoryofincidentList' => $subcategoryofincidentList,
                'classificationList' => $classificationList,

            );

            return view('incident.notification.add', $data);
        } catch (Exception $ex) {
            report($ex);
        }
    }

    public function Store(Request $request)
    {
        try {


            $rules = [
                'incident_remarks' => 'required',
            ];
            $messages = [
                'incident_remarks.required' => 'Please enter Incident Remarks',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            try {

                $incident = $this->notification->store();

                if ($incident) {

                    $insert_array = array(
                        'incident_id' => $incident->id,
                        'from_status' => 0,
                        'to_status' => INCIDENT_NOTIFICATION_STATUS_GHSE_PENDING,
                        'is_reject' => 0,
                        'remarks' => $request->incident_remarks,
                        'created_by' => Auth::id(),
                    );
                    $this->statuslog->create($insert_array);

                    /**
                     * Send Email Notification
                     */

                    $email_id = 'gowtham.ardhas@gmail.com';

                    $mailsubject = 'Incident Notification Created';



                    if ($email_id != '' || $email_id != null) {

                        $Incidentdetails =  $this->notification->selectOne($incident->id);
                        $IncidentArray  = $Incidentdetails->toArray();


                        $IncidentArray['name'] = 'Gowtham';
                        $IncidentArray['email_id'] =  $email_id;
                        $IncidentArray['mail_subject'] = $mailsubject;

                        //  Mail::to($IncidentArray['email_id'])->queue(new MachineryEmail($IncidentArray));
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
                            'message' => 'Incident Notification' . $incident->incident_id . ' created by ' . getUsername($incident->created_by),
                            'icon' => 'public/assets/images/notification/uauc.png',
                            'id' => $incident->id,
                            'module' => 1,
                        )),
                        'web_link' =>  admin_url('incident/notification/view/' . encryptId($incident->id)),
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
                        'message' => 'Incident Notification' . $incident->machinery_id . ' created by ' . getUsername($incident->created_by),
                    ];
                    mobilePushNotification($userId, $notifydata);

                    Session::flash('success', 'Incident Notification Created successfully!');
                } else {

                    dd($ex);
                    Session::flash('error', 'Something went wrong, Please try after sometimes!');
                }
            } catch (Exception $ex) {

                dd($ex);
                Session::flash('error', 'Something went wrong, Please try after sometimes!');
            }


            return redirect(admin_url('incident/notification/list'));
        } catch (Exception $ex) {
            dd($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('incident/notification/list'));
        }
    }

    public function View(Request $request)
    {
        try {

            $id = decryptId($request->id);

            $IncidentDetails = $this->notification->selectOne($id);
            $statuslogs = $this->statuslog->getDetails($id);

            $companyDetails = $this->company->get();
            $locationDetails = $this->location->get();
            $specificlocationDetails = $this->specificlocation->get();

            $emergencyincidenttireList = $this->item->getlist(EMERGENCY_INCIDENT_TIRE);
            $weatherconditionList = $this->item->getlist(WEATHER_CONDITION);
            $locationList = $this->item->getlist(LOCATION);
            $incidentpotentialList = $this->item->getlist(INCIDENT_POTENTIAL);
            $authoritiesinformList = $this->item->getlist(AUTHORITIES_INFORM);
            $incidentclassificationList = $this->item->getlist(INCIDENT_CLASSIFICATION);
            $typeofnotificationList = $this->item->getlist(TYPE_OF_NOTIFICATION);
            $categoryofincidentList = $this->item->getlist(CATEGORY_OF_INCIDENT);

            $subcategoryofincidentList = $this->subitem->getlist(CATEGORY_OF_INCIDENT);

            $classificationList = $this->classification->getList();

            $data = array(
                'companyDetails' => $companyDetails,
                'locationDetails' => $locationDetails,
                'specificlocationDetails' => $specificlocationDetails,
                'emergencyincidenttireList' => $emergencyincidenttireList,
                'weatherconditionList' => $weatherconditionList,
                'locationList' => $locationList,
                'incidentpotentialList' => $incidentpotentialList,
                'authoritiesinformList' => $authoritiesinformList,
                'incidentclassificationList' => $incidentclassificationList,
                'typeofnotificationList' => $typeofnotificationList,
                'categoryofincidentList' => $categoryofincidentList,
                'subcategoryofincidentList' => $subcategoryofincidentList,
                'classificationList' => $classificationList,

                'IncidentDetails' => $IncidentDetails,
                'statuslogs' => $statuslogs,


            );

            return view('incident.notification.view', $data);
        } catch (Exception $ex) {
        }
    }

    public function aproveReject(Request $request)
    {
        try {

            $id = decryptId($request->id);

            $IncidentDetails = $this->notification->selectOne($id);
            $statuslogs = $this->statuslog->getDetails($id);

            $companyDetails = $this->company->get();
            $locationDetails = $this->location->get();
            $specificlocationDetails = $this->specificlocation->get();

            $emergencyincidenttireList = $this->item->getlist(EMERGENCY_INCIDENT_TIRE);
            $weatherconditionList = $this->item->getlist(WEATHER_CONDITION);
            $locationList = $this->item->getlist(LOCATION);
            $incidentpotentialList = $this->item->getlist(INCIDENT_POTENTIAL);
            $authoritiesinformList = $this->item->getlist(AUTHORITIES_INFORM);
            $incidentclassificationList = $this->item->getlist(INCIDENT_CLASSIFICATION);
            $typeofnotificationList = $this->item->getlist(TYPE_OF_NOTIFICATION);
            $categoryofincidentList = $this->item->getlist(CATEGORY_OF_INCIDENT);

            $subcategoryofincidentList = $this->subitem->getlist(CATEGORY_OF_INCIDENT);

            $classificationList = $this->classification->getList();

            $data = array(
                'companyDetails' => $companyDetails,
                'locationDetails' => $locationDetails,
                'specificlocationDetails' => $specificlocationDetails,
                'emergencyincidenttireList' => $emergencyincidenttireList,
                'weatherconditionList' => $weatherconditionList,
                'locationList' => $locationList,
                'incidentpotentialList' => $incidentpotentialList,
                'authoritiesinformList' => $authoritiesinformList,
                'incidentclassificationList' => $incidentclassificationList,
                'typeofnotificationList' => $typeofnotificationList,
                'categoryofincidentList' => $categoryofincidentList,
                'subcategoryofincidentList' => $subcategoryofincidentList,
                'classificationList' => $classificationList,

                'IncidentDetails' => $IncidentDetails,
                'statuslogs' => $statuslogs,
                'approve_status' => 'YES',

            );

            return view('incident.notification.view', $data);
        } catch (Exception $ex) {
        }
    }

    public function ApproveRejectSubmit(Request $request)
    {

        try {

            $id = decryptId($request->id);
            $Incident = $this->notification->find($id);

            if ($request->has('approve')) {
                $is_reject = 0;
                $status = INCIDENT_NOTIFICATION_STATUS_GHSE_APPROVED;

                $this->investgation->store($Incident);
            } else if ($request->has('reject')) {
                $is_reject = 1;
                $status =  INCIDENT_NOTIFICATION_STATUS_GHSE_REJECTED;
            }

            $incident_id = $Incident->id;

            $insert_array = array(
                'incident_id' => $incident_id,
                'from_status' => INCIDENT_NOTIFICATION_STATUS_GHSE_PENDING,
                'to_status' => $status,
                'is_reject' => $is_reject,
                'remarks' => $request->remarks,
                'created_by' => Auth::id(),
            );
            $this->statuslog->create($insert_array);

            $this->notification->where('id', $id)->update(['incident_status' => $status, 'incident_classification' =>  json_encode($request->incidentclassification), 'incident_rating' => decryptId($request->incident_rating)]);

            return redirect('incident/notification/list');
        } catch (Exception $ex) {

            report($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('incident/notification/list'));
        }
    }

    public function Edit(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $IncidentDetails = $this->notification->selectOne($id);
            $statuslogs = $this->statuslog->getDetails($id);

            $companyDetails = $this->company->getAllCompany();


            $emergencyincidenttireList = $this->item->getlist(EMERGENCY_INCIDENT_TIRE);
            $weatherconditionList = $this->item->getlist(WEATHER_CONDITION);
            $locationList = $this->item->getlist(LOCATION);
            $incidentpotentialList = $this->item->getlist(INCIDENT_POTENTIAL);
            $authoritiesinformList = $this->item->getlist(AUTHORITIES_INFORM);
            $incidentclassificationList = $this->item->getlist(INCIDENT_CLASSIFICATION);
            $typeofnotificationList = $this->item->getlist(TYPE_OF_NOTIFICATION);
            $categoryofincidentList = $this->item->getlist(CATEGORY_OF_INCIDENT);

            $subcategoryofincidentList = $this->subitem->getlist(CATEGORY_OF_INCIDENT);

            $classificationList = $this->classification->getList();

            $locationDetails = $this->location->getcompany($IncidentDetails->company_id);
            $specificlocationDetails = $this->specificlocation->getlocation($IncidentDetails->location_id);

            $data = array(
                'companyDetails' => $companyDetails,
                'locationDetails' => $locationDetails,
                'specificlocationDetails' => $specificlocationDetails,
                'emergencyincidenttireList' => $emergencyincidenttireList,
                'weatherconditionList' => $weatherconditionList,
                'locationList' => $locationList,
                'incidentpotentialList' => $incidentpotentialList,
                'authoritiesinformList' => $authoritiesinformList,
                'incidentclassificationList' => $incidentclassificationList,
                'typeofnotificationList' => $typeofnotificationList,
                'categoryofincidentList' => $categoryofincidentList,
                'subcategoryofincidentList' => $subcategoryofincidentList,
                'classificationList' => $classificationList,
                'IncidentDetails' => $IncidentDetails,
                'statuslogs' => $statuslogs,
            );
            return view('incident.notification.edit', $data);
        } catch (Exception $error) {

            report($error);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('incident/notification/list'));
        }
    }

    public function Update(Request $request)
    {
        try {

            $id = decryptId($request->id);
            $Incident = $this->notification->find($id);

            $status = INCIDENT_NOTIFICATION_STATUS_GHSE_PENDING;
            $is_reject = 0;


            $incident_id = $Incident->id;

            $insert_array = array(
                'incident_id' => $incident_id,
                'from_status' => INCIDENT_NOTIFICATION_STATUS_GHSE_REJECTED,
                'to_status' => $status,
                'is_reject' => $is_reject,
                'remarks' => $request->incident_remarks,
                'created_by' => Auth::id(),
            );
            $this->statuslog->create($insert_array);

            $this->notification->updates($id);

            Session::flash('success', 'Incident Norification successfully updated');
            return redirect('incident/notification/list');
        } catch (Exception $ex) {
            report($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('incident/notification/list'));
        }
    }

    public function Delete(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $this->notification->deleterecord($id);

            return response()->json(['status' => 'success', 'msg' => 'Location deleted successfully'], 200);
        } catch (Exception $ex) {

            return response()->json(['status' => 'error', 'msg' => 'Please try after some time'], 406);
        }
    }

    public function ExportExcel(Request $request)
    {

        try {

            $allData = $this->notification->exportdata();

            $header = [
                'No.',
                'Incident ID',
                'Incident Type',
                'Location',
                'Incident Date',
                'Status',
                'Created By',
                'Created Date',
            ];


            $i = 1;
            foreach ($allData as $data) {

                $export = [];

                $export[] =  $i;
                $export[] =  $data->incident_id;
                $export[] =  getIncidentTypeName($data->incident_type);
                $export[] =  getLocationName($data->location_id);
                $export[] =  Displaydateformat($data->incident_date);
                $export[] = strip_tags(incidentStatus($data->incident_status));
                $export[] =  getusername($data->created_by);
                $export[] =  Displaydateformat($data->created_at);

                $exportData[] = $export;

                $i++;
            }

            $writer = SimpleExcelWriter::streamDownload('Incident Notification List.xlsx')
                ->addHeader($header)
                ->addRows(
                    $exportData
                );
        } catch (Exception $ex) {

            report($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('incident/notification/list'));
        }
    }

    public function ExportPdf(Request $request)
    {
        try {

            $allData = $this->notification->exportdata();
            $header = [
                'No.',
                'Incident ID',
                'Incident Type',
                'Location',
                'Incident Date',
                'Status',
                'Created By',
                'Created Date',
            ];


            $data = array(
                'header' => $header,
                'content' => $allData,
                'pagetitle' => "Incident Notification Details",
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

            $view = view('incident.notification.pdf', $data);
            $html = $view->render();


            $mpdf->WriteHTML($html);

            $filename = "Incident Notification List.pdf";
            $mpdf->Output($filename, 'D');
        } catch (Exception $ex) {
            report($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('incident/notification/list'));
        }
    }



    public function ExportViewPdf(Request $request)
    {

        try {

            $id = decryptId($request->id);

            $IncidentDetails = $this->notification->selectOne($id);
            $statuslogs = $this->statuslog->getDetails($id);

            $Incidenttype = $IncidentDetails->incident_type;

            $where = array(
                'Incidenttype_id' => $Incidenttype
            );

            $IncidenttypeDetails = $this->Incidenttype->find($Incidenttype);

            $checklistCategoryDetails =  $this->checklistcategory->where($where)->get();
            $checklistItemList = $this->checklistitem->where($where)->get();

            $checklistItemDetails = [];
            foreach ($checklistItemList as $checklistItem) {
                $checklistItemDetails[$checklistItem->category_id][] = $checklistItem;
            }

            $Incidentchecklistitem = $this->Incidentdetails->where('incident_id', $id)->get()->keyBy('checklist_item');

            $IncidentFileDetails =   $this->Incidentfile->getIncidentfiles($id);

            $IncidentFiles = [];

            foreach ($IncidentFileDetails as $IncidentFile) {
                $IncidentFiles[$IncidentFile->item_id][] = $IncidentFile;
            }

            $IncidentMainFileDetails =   $this->Incidentmainfile->getIncidentfiles($id);

            $data = array(
                'IncidenttypeDetails' => $IncidenttypeDetails,
                'checklistCategoryDetails' => $checklistCategoryDetails,
                'checklistItemDetails' => $checklistItemDetails,
                'IncidentDetails' => $IncidentDetails,
                'Incidentchecklistitem' => $Incidentchecklistitem,
                'IncidentFiles' => $IncidentFiles,
                'IncidentMainFileDetails' => $IncidentMainFileDetails,
                'statuslogs' => $statuslogs,
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

            $view = view('incident.notification.pdf.Incident', $data);
            $html = $view->render();

            $mpdf->WriteHTML($html);

            $filename = $IncidentDetails->incident_id . ".pdf";
            $mpdf->Output($filename, 'D');
        } catch (Exception $ex) {

            dd($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('incident/notification/list'));
        }
    }

    // Incident Open Close

    public function getIncidentOpenClose()
    {
        try {

            $incident = $this->notification->getIncidentOpenClose();

            $data = [
                'incident' => $incident
            ];

            return view('incident.dashboard.notificationopenclose', $data);
        } catch (Exception $ex) {
            report($ex);
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }
}
