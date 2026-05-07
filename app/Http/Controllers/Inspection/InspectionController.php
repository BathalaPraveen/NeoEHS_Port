<?php

namespace App\Http\Controllers\Inspection;

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

use App\Models\Inspection\InspectionType;
use App\Models\Inspection\ChecklistCategory;
use App\Models\Inspection\ChecklistItem;

use App\Models\Inspection\Inspection;
use App\Models\Inspection\InspectionDetails;

use App\Models\Inspection\InspectionStatus;
use App\Models\Inspection\InspectionStatusLog;
use App\Models\Inspection\InspectionFile;
use App\Models\Inspection\InspectionMainFile;
use App\Models\Inspection\JettyLocation;


class InspectionController extends Controller
{

    private $company;
    private $division;
    private $department;
    private $location;
    private $specificlocation;

    private $inspectiontype;
    private $checklistcategory;
    private $checklistitem;

    private $inspection;
    private $inspectiondetails;

    private $status;
    private $statuslog;
    private $inspectionfile;
    private $inspectionmainfile;

    private $jettylocation;

    public function __construct()
    {

        $this->company = new Company();
        $this->division = new Division();
        $this->department = new Department();
        $this->location = new Location();
        $this->specificlocation = new SpecificLocation();

        $this->inspectiontype = new InspectionType();
        $this->checklistcategory = new ChecklistCategory();
        $this->checklistitem = new ChecklistItem();

        $this->inspection =  new Inspection();
        $this->inspectiondetails =  new InspectionDetails();
        $this->inspectionfile =  new InspectionFile();
        $this->inspectionmainfile =  new InspectionMainFile();

        $this->status =  new InspectionStatus();
        $this->statuslog =  new InspectionStatusLog();

        $this->jettylocation =  new JettyLocation();
    }

    public function index(Request $request)
    {

        if (Auth::check()) {
            if ($request->ajax()) {
                try {

                    $data =  $this->inspection->list();

                    $datatables = Datatables::of($data['data'])
                        ->addIndexColumn()
                        ->addColumn('inspection_date', function ($row) {
                            return Displaydateformat($row->inspection_date);
                        })
                        ->addColumn('assigned_user', function ($row) {
                            return getusername($row->assign_to);
                        })
                        ->addColumn('inspection_status', function ($row) {
                            $text = inspectionStatus($row->inspection_status);
                            return $text;
                        })
                        ->addColumn('action', function ($row) {
                            $btn = '';
                            $btn  = '<a href="' . admin_url('inspection/inspection/view/' . encryptId($row->id)) . '"   class="" title="View"><i class="fa-solid fa-eye"></i></a> ';
                            if ($row->inspection_status == INSPECTION_STATUS_INSPECTION_COMPLETED && (CheckUserRole(ROLE_SUPERADMIN) || (CheckUserRole(ROLE_HOD)) )) {
                                $btn .= '<a href="' . admin_url('inspection/inspection/approvereject/' . encryptId($row->id)) . '"   class="" title="Approve / Reject"><i class="fa-solid fa-check-to-slot"></i></a> ';
                            }

                            if ($row->inspection_status == INSPECTION_STATUS_HOD_REJECTED) {
                                $btn .= '<a href="' . admin_url('inspection/inspection/edit/' . encryptId($row->id)) . '"   class="" title="Edit"><i class="fa-solid fa-edit"></i></a> ';
                            }

                            if ($row->inspection_status == INSPECTION_STATUS_ASSIGNED) {
                                $btn .= '<a href="' . admin_url('inspection/inspection/add/' . encryptId($row->id)) . '"   class="" title="inspection"><img style="width:20px;vertical-align: sub;" src="' . url('public/assets/images/icons/inspection.png') . '" alt="Approve/ Reject" ></a> ';
                            }
                            if ($row->inspection_status != INSPECTION_STATUS_ASSIGNED) {
                                $btn .= '<a href="' . admin_url('inspection/inspection/view/pdf/' . encryptId($row->id)) . '" class=" " title="Pdf"><i class="fa fa-file-pdf-o"></i></a> ';
                            }
                            return $btn;
                        })
                        ->rawColumns(['action', 'created_date', 'created_by', 'inspection_status'])
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
        $inspectiontypeDetails = $this->inspectiontype->get();
        $status = $this->status->get();


        $data = array(
            'locationDetails' => $locationDetails,
            'inspectiontypeDetails' => $inspectiontypeDetails,
            'statusDetails' => $status,
        );

        return view('inspection.inspection.list', $data);
    }

    public function Create(Request $request)
    {

        try {

            $companyDetails = $this->company->getAllCompany();
            $locationDetails = $this->location->getAllLocation();
            $specificlocationDetails = $this->specificlocation->get();
            $inspectiontypeDetails = $this->inspectiontype->get();
            $assigntousers = User::where(['role' => ROLE_NORMAL_USER])->get();

            $data = array(
                'companyDetails' => $companyDetails,
                'locationDetails' => $locationDetails,
                'specificlocationDetails' => $specificlocationDetails,
                'inspectiontypeDetails' => $inspectiontypeDetails,
                'assigntousers' => $assigntousers,
            );
            return view('inspection.inspection.create', $data);
        } catch (Exception $ex) {

            report($ex);
        }
    }

    public function CreateSubmit(Request $request)
    {
        try {

            $rules = [
                'inspectiontype' => 'required',
                'location' => 'required',
                'specific_location' => 'required',

            ];
            $messages = [
                'inspectiontype.required' => 'Please select Inspection Type',
                'location.required' => 'Please select Location',
                'specific_location.required' => 'Please select Specific Location',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            try {

                $inspection =  $this->inspection->createinspection();

                $insert_array = array(
                    'inspection_id' => $inspection->id,
                    'from_status' => 0,
                    'to_status' => INSPECTION_STATUS_ASSIGNED,
                    'is_reject' => 0,
                    'remarks' => "New Inspection created",
                    'created_by' => Auth::id(),
                );
                $this->statuslog->create($insert_array);


            } catch (Exception $ex) {

                dd($ex);
                Session::flash('error', 'Something went wrong, Please try after sometimes!');
            }


            return redirect(admin_url('inspection/inspection/add/'.encryptId($inspection->id)));
        } catch (Exception $ex) {
            //
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('inspection/inspection/list'));
        }
    }

    public function Add(Request $request)
    {

        try {

            $id = decryptId($request->id);

            $locationDetails = $this->location->getAllLocation();
            $specificlocationDetails = $this->specificlocation->get();
            $inspectiontypeDetails = $this->inspectiontype->get();
            $inspectionDetails = $this->inspection->selectOne($id);

           $inspectiontype =   $this->inspectiontype->find($inspectionDetails->inspection_type);

            $data = array(
                'locationDetails' => $locationDetails,
                'specificlocationDetails' => $specificlocationDetails,
                'inspectiontypeDetails' => $inspectiontypeDetails,
                'inspectionDetails' => $inspectionDetails,
                'inspection_type' => $inspectiontype,
            );

            return view('inspection.inspection.add', $data);
        } catch (Exception $ex) {

            report($ex);
        }
    }

    public function getCheckList(Request $request)
    {

        $inspectiontype = decryptId($request->inspectiontype);

        $where = array(
            'inspectiontype_id' => $inspectiontype
        );

        $inspectiontypeDetails = $this->inspectiontype->find($inspectiontype);
        $checklistCategoryDetails =  $this->checklistcategory->where($where)->orderBy('sort_order','ASC')->get();
        $checklistItemList = $this->checklistitem->where($where)->get();

        $checklistItemDetails = [];

        foreach ($checklistItemList as $checklistItem) {
            $checklistItemDetails[$checklistItem->category_id][] = $checklistItem;
        }

        $msdUserDetails = User::msdusers();
        $tsdUserDetails = User::tsdusers();
        $caretakerDetails = User::caretakerusers();

        $craneOperatorDetails = User::craneoperatorusers();

        $jettylocation = $this->jettylocation->get();

        $data = array(
            'inspectiontypeDetails' => $inspectiontypeDetails,
            'checklistCategoryDetails' => $checklistCategoryDetails,
            'checklistItemDetails' => $checklistItemDetails,
            'msdUserDetails' => $msdUserDetails,
            'tsdUserDetails' => $tsdUserDetails,
            'caretakerDetails' => $caretakerDetails,
            'craneOperatorDetails' => $craneOperatorDetails,
            'jettylocation' => $jettylocation,
        );

        return view('inspection.inspection.checklist', $data);
    }

    public function Store(Request $request)
    {
        try {

            $rules = [
                'inspectionremarks' => 'required',
            ];
            $messages = [
                'inspectionremarks.required' => 'Please enter Inspection Remarks',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $id = decryptId($request->id);

            try {

                $this->inspection->store();
                $inspection = $this->inspection->find($id);

                if ($inspection) {

                    $this->inspectiondetails->store($inspection);
                    $this->inspectionfile->store($inspection);
                    $this->inspectionmainfile->store($inspection);

                    $insert_array = array(
                        'inspection_id' => $inspection->id,
                        'from_status' => INSPECTION_STATUS_ASSIGNED,
                        'to_status' => INSPECTION_STATUS_INSPECTION_COMPLETED,
                        'is_reject' => 0,
                        'remarks' => $request->inspectionremarks,
                        'created_by' => Auth::id(),
                    );
                    $this->statuslog->create($insert_array);



                    /**
                     * Send Email Notification
                     */

                    $email_id = 'gowtham.ardhas@gmail.com';

                    $mailsubject = 'Inspection Completed';



                    if ($email_id != '' || $email_id != null) {

                        $inspectiondetails =  $this->inspection->selectOne($inspection->id);
                        $inspectionArray  = $inspectiondetails->toArray();


                        $inspectionArray['name'] = 'Gowtham';
                        $inspectionArray['email_id'] =  $email_id;
                        $inspectionArray['mail_subject'] = $mailsubject;

                        //  Mail::to($inspectionArray['email_id'])->queue(new MachineryEmail($inspectionArray));
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
                            'message' => 'Inspection ' . $inspection->inspection_id . ' completed by ' . getUsername($inspection->created_by),
                            'icon' => 'public/assets/images/notification/uauc.png',
                            'id' => $inspection->id,
                            'module' => 1,
                        )),
                        'web_link' =>  admin_url('inspection/inspection/view/' . encryptId($inspection->id)),
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
                        'message' => 'Inspection ' . $inspection->machinery_id . ' completed by ' . getUsername($inspection->created_by),
                    ];
                    mobilePushNotification($userId, $notifydata);

                    Session::flash('success', 'Inspection completed successfully!');
                } else {
                    Session::flash('error', 'Something went wrong, Please try after sometimes!');
                }
            } catch (Exception $ex) {
                dd($ex);
                Session::flash('error', 'Something went wrong, Please try after sometimes!');
            }


            return redirect(admin_url('inspection/inspection/list'));
        } catch (Exception $ex) {
            dd($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('inspection/inspection/list'));
        }
    }

    public function View(Request $request)
    {
        try {

            $id = decryptId($request->id);

            $inspectionDetails = $this->inspection->selectOne($id);
            $statuslogs = $this->statuslog->getDetails($id);

            $inspectiontype = $inspectionDetails->inspection_type;

            $where = array(
                'inspectiontype_id' => $inspectiontype
            );

            $inspectiontypeDetails = $this->inspectiontype->find($inspectiontype);

            $checklistCategoryDetails =  $this->checklistcategory->where($where)->get();
            $checklistItemList = $this->checklistitem->where($where)->get();

            $checklistItemDetails = [];
            foreach ($checklistItemList as $checklistItem) {
                $checklistItemDetails[$checklistItem->category_id][] = $checklistItem;
            }

            $inspectionchecklistitem = $this->inspectiondetails->where('inspection_id', $id)->get()->keyBy('checklist_item');

            $inspectionFileDetails =   $this->inspectionfile->getinspectionfiles($id);
            $inspectionMainFileDetails =   $this->inspectionmainfile->getinspectionfiles($id);

            $inspectionFiles = [];

            foreach ($inspectionFileDetails as $inspectionFile) {
                $inspectionFiles[$inspectionFile->item_id][] = $inspectionFile;
            }

            $data = array(
                'inspectiontypeDetails' => $inspectiontypeDetails,
                'checklistCategoryDetails' => $checklistCategoryDetails,
                'checklistItemDetails' => $checklistItemDetails,
                'inspectionDetails' => $inspectionDetails,
                'inspectionchecklistitem' => $inspectionchecklistitem,
                'inspectionFiles' => $inspectionFiles,
                'inspectionMainFileDetails' => $inspectionMainFileDetails,
                'statuslogs' => $statuslogs,
            );


            return view('inspection.inspection.view', $data);
        } catch (Exception $ex) {
        }
    }

    public function ApproveReject(Request $request)
    {
        try {


            $id = decryptId($request->id);

            $inspectionDetails = $this->inspection->selectOne($id);
            $statuslogs = $this->statuslog->getDetails($id);

            $inspectiontype = $inspectionDetails->inspection_type;

            $where = array(
                'inspectiontype_id' => $inspectiontype
            );

            $inspectiontypeDetails = $this->inspectiontype->find($inspectiontype);

            $checklistCategoryDetails =  $this->checklistcategory->where($where)->get();
            $checklistItemList = $this->checklistitem->where($where)->get();

            $checklistItemDetails = [];
            foreach ($checklistItemList as $checklistItem) {
                $checklistItemDetails[$checklistItem->category_id][] = $checklistItem;
            }

            $inspectionchecklistitem = $this->inspectiondetails->where('inspection_id', $id)->get()->keyBy('checklist_item');

            $inspectionFileDetails =   $this->inspectionfile->getinspectionfiles($id);
            $inspectionMainFileDetails =   $this->inspectionmainfile->getinspectionfiles($id);

            $inspectionFiles = [];

            foreach ($inspectionFileDetails as $inspectionFile) {
                $inspectionFiles[$inspectionFile->item_id][] = $inspectionFile;
            }

            $data = array(
                'inspectiontypeDetails' => $inspectiontypeDetails,
                'checklistCategoryDetails' => $checklistCategoryDetails,
                'checklistItemDetails' => $checklistItemDetails,
                'inspectionDetails' => $inspectionDetails,
                'inspectionchecklistitem' => $inspectionchecklistitem,
                'statuslogs' => $statuslogs,
                'inspectionFiles' => $inspectionFiles,
                'inspectionMainFileDetails' => $inspectionMainFileDetails,
                'approvereject' => 'YES',
            );

            return view('inspection.inspection.view', $data);
        } catch (Exception $ex) {

            report($ex);
        }
    }

    public function ApproveRejectSubmit(Request $request)
    {

        try {

            $id = decryptId($request->id);
            $inspection = $this->inspection->find($id);

            if ($request->has('approve')) {
                $is_reject = 0;
                $status = INSPECTION_STATUS_HOD_APPROVED;
            } else if ($request->has('reject')) {
                $is_reject = 1;
                $status =  INSPECTION_STATUS_HOD_REJECTED;
            }

            $inspection_id = $inspection->id;

            $insert_array = array(
                'inspection_id' => $inspection_id,
                'from_status' => INSPECTION_STATUS_INSPECTION_COMPLETED,
                'to_status' => $status,
                'is_reject' => $is_reject,
                'remarks' => $request->remarks,
                'created_by' => Auth::id(),
            );
            $this->statuslog->create($insert_array);

            $this->inspection->where('id', $id)->update(['inspection_status' => $status]);

            return redirect('inspection/inspection/list');
        } catch (Exception $ex) {
            report($ex);
        }
    }

    public function Edit(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $inspectionDetails = $this->inspection->selectOne($id);
            $statuslogs = $this->statuslog->getDetails($id);

            $inspectiontype = $inspectionDetails->inspection_type;

            $where = array(
                'inspectiontype_id' => $inspectiontype
            );

            $inspectiontypeDetails = $this->inspectiontype->find($inspectiontype);

            $checklistCategoryDetails =  $this->checklistcategory->where($where)->get();
            $checklistItemList = $this->checklistitem->where($where)->get();

            $checklistItemDetails = [];
            foreach ($checklistItemList as $checklistItem) {
                $checklistItemDetails[$checklistItem->category_id][] = $checklistItem;
            }

            $inspectionchecklistitem = $this->inspectiondetails->where('inspection_id', $id)->get()->keyBy('checklist_item');

            $inspectionFileDetails =   $this->inspectionfile->getinspectionfiles($id);
            $inspectionMainFileDetails =   $this->inspectionmainfile->getinspectionfiles($id);

            $inspectionFiles = [];

            foreach ($inspectionFileDetails as $inspectionFile) {
                $inspectionFiles[$inspectionFile->item_id][] = $inspectionFile;
            }

            $data = array(
                'inspectiontypeDetails' => $inspectiontypeDetails,
                'checklistCategoryDetails' => $checklistCategoryDetails,
                'checklistItemDetails' => $checklistItemDetails,
                'inspectionDetails' => $inspectionDetails,
                'inspectionchecklistitem' => $inspectionchecklistitem,
                'statuslogs' => $statuslogs,
                'inspectionFiles' => $inspectionFiles,
                'inspectionMainFileDetails' => $inspectionMainFileDetails,
                'approvereject' => 'YES',
            );

            return view('inspection.inspection.view', $data);
        } catch (Exception $error) {
            report($error->getMessage());
        }
    }

    public function Update(Request $request)
    {
        try {



            $id = decryptId($request->id);
            $inspection = $this->inspection->find($id);

            $status = INSPECTION_STATUS_INSPECTION_COMPLETED;
            $is_reject = 0;


            $inspection_id = $inspection->id;

            $insert_array = array(
                'inspection_id' => $inspection_id,
                'from_status' => INSPECTION_STATUS_HOD_REJECTED,
                'to_status' => $status,
                'is_reject' => $is_reject,
                'remarks' => $request->remarks,
                'created_by' => Auth::id(),
            );
            $this->statuslog->create($insert_array);

            $this->inspection->where('id', $id)->update(['inspection_status' => $status]);

            Session::flash('success', 'Inspection successfully updated');
            return redirect('inspection/inspection/list');
        } catch (Exception $ex) {

            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('inspection/inspection/list'));
        }
    }

    public function Delete(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $this->inspection->deleterecord($id);

            return response()->json(['status' => 'success', 'msg' => 'Location deleted successfully'], 200);
        } catch (Exception $ex) {

            return response()->json(['status' => 'error', 'msg' => 'Please try after some time'], 406);
        }
    }

    public function ExportExcel(Request $request)
    {

        try {

            $allData = $this->inspection->exportdata();

            $header = [
                'No.',
                'Inspection ID',
                'Inspection Type',
                'Location',
                'Inspection Date',
                'Assign To',
                'Status',
                'Created By',
                'Created Date',
            ];


            $i = 1;
            foreach ($allData as $data) {

                $export = [];

                $export[] =  $i;
                $export[] =  $data->inspection_id;
                $export[] =  $data->inspectiontype_name;
                $export[] =  $data->location_name;
                $export[] =  $data->inspection_date;
                $export[] =  getusername($data->assign_to);
                $export[] =  $data->status_name;
                $export[] =  getusername($data->created_by);
                $export[] =  Displaydateformat($data->created_at);

                $exportData[] = $export;

                $i++;
            }

            $writer = SimpleExcelWriter::streamDownload('Inspection List.xlsx')
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

            $allData = $this->inspection->exportdata();
            $header = [
                'No.',
                'Inspection ID',
                'Inspection Type',
                'Location',
                'Inspection Date',
                'Assign To',
                'Status',
                'Created By',
                'Created Date',
            ];


            $data = array(
                'header' => $header,
                'content' => $allData,
                'pagetitle' => "Inspection Details",
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

            $view = view('inspection.inspection.pdf', $data);
            $html = $view->render();


            $mpdf->WriteHTML($html);

            $filename = "Inspection List.pdf";
            $mpdf->Output($filename, 'D');
        } catch (Exception $ex) {

            report($ex);
        }
    }

    public function ExportViewPdf(Request $request)
    {

        try {

            $id = decryptId($request->id);

            $inspectionDetails = $this->inspection->selectOne($id);
            $statuslogs = $this->statuslog->getDetails($id);

            $inspectiontype = $inspectionDetails->inspection_type;

            $where = array(
                'inspectiontype_id' => $inspectiontype
            );

            $inspectiontypeDetails = $this->inspectiontype->find($inspectiontype);

            $checklistCategoryDetails =  $this->checklistcategory->where($where)->get();
            $checklistItemList = $this->checklistitem->where($where)->get();

            $checklistItemDetails = [];
            foreach ($checklistItemList as $checklistItem) {
                $checklistItemDetails[$checklistItem->category_id][] = $checklistItem;
            }

            $inspectionchecklistitem = $this->inspectiondetails->where('inspection_id', $id)->get()->keyBy('checklist_item');

            $inspectionFileDetails =   $this->inspectionfile->getinspectionfiles($id);

            $inspectionFiles = [];

            foreach ($inspectionFileDetails as $inspectionFile) {
                $inspectionFiles[$inspectionFile->item_id][] = $inspectionFile;
            }

            $inspectionMainFileDetails =   $this->inspectionmainfile->getinspectionfiles($id);

            $data = array(
                'inspectiontypeDetails' => $inspectiontypeDetails,
                'checklistCategoryDetails' => $checklistCategoryDetails,
                'checklistItemDetails' => $checklistItemDetails,
                'inspectionDetails' => $inspectionDetails,
                'inspectionchecklistitem' => $inspectionchecklistitem,
                'inspectionFiles' => $inspectionFiles,
                'inspectionMainFileDetails' => $inspectionMainFileDetails,
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

            $view = view('inspection.inspection.pdf.inspection', $data);
            $html = $view->render();

            $mpdf->WriteHTML($html);

            $filename = $inspectionDetails->inspection_id . ".pdf";
            $mpdf->Output($filename, 'D');
        } catch (Exception $ex) {

            report($ex);
        }
    }
}
