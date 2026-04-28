<?php

namespace App\Http\Controllers\HIRADC;

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

use App\Models\HIRADC\Document;
use App\Models\HIRADC\DocumentType;
use App\Models\HIRADC\Category;
use App\Models\HIRADC\ProcessType;
use App\Models\HIRADC\ProcessTypeDetails;
use App\Models\HIRADC\Hazard;
use App\Models\HIRADC\HazardList;
use App\Models\HIRADC\Likelihood;
use App\Models\HIRADC\Severity;
use App\Models\HIRADC\RiskMatrix;
use App\Models\HIRADC\RiskStatus;


class HIRADCController extends Controller
{

    private $document;
    private $documenttype;
    private $category;
    private $preocestype;
    private $processtypedetails;
    private $hazard;
    private $hazardlist;
    private $status;
    private $statuslog;

    public function __construct()
    {

        $this->document = new Document();
        $this->documenttype = new DocumentType();
        $this->category = new Category();
        $this->hazard = new Hazard();
        $this->hazardlist = new HazardList();
        $this->preocestype = new ProcessType();
        $this->processtypedetails = new ProcessTypeDetails();
        $this->statuslog = new RiskStatus();
    }

    public function index(Request $request)
    {

        if (Auth::check()) {
            if ($request->ajax()) {
                try {

                    $data =  $this->hazard->list();

                    $datatables = Datatables::of($data['data'])
                        ->addIndexColumn()
                        ->addColumn('created_date', function ($row) {
                            return Displaydateformat($row->created_at);
                        })
                        ->addColumn('created_user', function ($row) {
                            return getUsername($row->created_by);
                        })
                        ->addColumn('risk_status', function ($row) {
                            $text = mainStatus($row->approve_status);

                            return $text;
                        })

                        ->addColumn('action', function ($row) {
                            $btn = '';
                            $btn .= '<a href="' . admin_url('hiradc/hiradc/view/' . encryptId($row->id)) . '"  title="View"><i class="fa-solid fa-eye"></i> </a>';
                            if ($row->approve_status != 2){

                                $btn .= '<a href="' . admin_url('hiradc/hiradc/edit/' . encryptId($row->id)) . '"  title="Edit"><i class="fa-solid fa-pen-to-square"></i></a> ';
                            }
                            if ($row->approve_status == 1 && (CheckUserRole(ROLE_SUPERADMIN) || (CheckUserRole(ROLE_HIRADC_HOD_APPROVER)) )){
                                $btn .= '<a href="' . admin_url('hiradc/hiradc/approve/supervisor/' . encryptId($row->id)) . '"  title="Approve"><i class="fa-solid fa-check-to-slot"></i> </a>';
                            }

                            $btn .= '<a href="javascript:void(0);"  data-id="' . encryptId($row->id) . '"  class="recordDelete" title="Delete"><i class="fa-solid fa-trash text-danger" ></i></a> ';
                            return $btn;
                        })
                        ->rawColumns(['action', 'created_date', 'created_by', 'status', 'risk_status'])
                        ->setFilteredRecords($data['total_records'])
                        ->setTotalRecords($data['total_records'])
                        ->skipPaging()
                        ->make(true);
                    return $datatables;
                } catch (Exception $ex) {

                    return response()->json(['status' => 'error', 'msg' => 'Please try after some time', $ex], 406);
                }
            }
        }

        $documentdetails = $this->document->get();
        $processtypeList = $this->preocestype->get();
        $data = array(
            'documentdetails' =>  $documentdetails,
            'processtypeList' =>  $processtypeList,
        );

        return view('hiradc.hiradc.list', $data);
    }

    public function Add(Request $request)
    {

        try {

            $documentdetails = $this->document->get();
            $processtypeList = $this->preocestype->get();
            $processtypeDetailsdata = $this->processtypedetails->get();

            $processtypedetails = [];

            foreach ($processtypeDetailsdata as $processtypeDetail) {
                $processtypedetails[$processtypeDetail->process_type_id][] = $processtypeDetail;
            }

            $data = array(
                'documentdetails' =>  $documentdetails,
                'processtypeList' =>  $processtypeList,
                'processtypedetails' =>  $processtypedetails,
            );


            return view('hiradc.hiradc.add', $data);
        } catch (Exception $ex) {
            report($ex);
        }
    }

    public function Store(Request $request)
    {
        try {


            $rules = [
                'document_type' => 'required',
            ];
            $messages = [
                'document_type.required' => 'Please select Document Type',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                Session::flash('error', 'Something went wrong, Please try after sometimes!');
                return redirect()->back()->withErrors($validator)->withInput();
            }

            try {

                $risk =  $this->hazard->store();
                $this->hazardlist->store($risk->id);

                $loginsert = array(
                    'risk_id' =>  $risk->id,
                    'from_status' => 0,
                    'to_status' => HIRADC_STATUS_PENDING,
                    'status_description' => $request->reporter_remarks,
                    'created_by' => Auth::id(),
                );

                $this->statuslog->create($loginsert);

                Session::flash('success', 'HIRADC added successfully!');
            } catch (Exception $ex) {

                Session::flash('error', 'Something went wrong, Please try after sometimes!');
            }

            return redirect(admin_url('hiradc/hiradc/list'));
        } catch (Exception $ex) {

            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('hiradc/hiradc/list'));
        }
    }

    public function View(Request $request)
    {
        try {
            $id = decryptId($request->id);
            if (Auth::check()) {

                $risk = $this->hazard->selectOne($id);
                $riskdetails = $this->hazardlist->getwhere(['hazard_id' => $id]);

                $documentdetails = $this->document->get();
                $processtypeList = $this->preocestype->get();
                $processtypeDetailsdata = $this->processtypedetails->get();

                $processtypedetails = [];

                foreach ($processtypeDetailsdata as $processtypeDetail) {
                    $processtypedetails[$processtypeDetail->process_type_id][] = $processtypeDetail;
                }

                $hiradc_status_log =  $this->statuslog->getlist($id);

                $data = array(
                    'risk' =>  $risk,
                    'riskdetails' =>  $riskdetails,
                    'documentdetails' =>  $documentdetails,
                    'processtypeList' =>  $processtypeList,
                    'processtypedetails' =>  $processtypedetails,
                    'hiradc_status_log' =>  $hiradc_status_log,
                );
            }
            return view('hiradc.hiradc.view', $data);
        } catch (Exception $ex) {
            dd($ex);
        }
    }

    public function Edit(Request $request)
    {
        try {
            $id = decryptId($request->id);
            if (Auth::check()) {

                $risk = $this->hazard->selectOne($id);
                $riskdetails = $this->hazardlist->getwhere(['hazard_id' => $id]);

                $documentdetails = $this->document->get();
                $processtypeList = $this->preocestype->get();
                $processtypeDetailsdata = $this->processtypedetails->get();

                $processtypedetails = [];

                foreach ($processtypeDetailsdata as $processtypeDetail) {
                    $processtypedetails[$processtypeDetail->process_type_id][] = $processtypeDetail;
                }

                $documentsubTypeDetails = $this->documenttype->getWhere($risk->document_type);
                $documentsubTypeCategoryDetails = $this->category->getWhere(['documenttype_id' => $risk->document_sub_type]);

                $data = array(
                    'risk' =>  $risk,
                    'riskdetails' =>  $riskdetails,
                    'documentdetails' =>  $documentdetails,
                    'documentsubTypeDetails' =>  $documentsubTypeDetails,
                    'documentsubTypeCategoryDetails' =>  $documentsubTypeCategoryDetails,
                    'processtypeList' =>  $processtypeList,
                    'processtypedetails' =>  $processtypedetails,
                );
            }

            return view('hiradc.hiradc.edit', $data);
        } catch (Exception $error) {
            report($error->getMessage());
        }
    }

    public function Update(Request $request)
    {
        try {
            $id = decryptId($request->id);


            $rules = [
                'document_type' => 'required',
            ];
            $messages = [
                'document_type.required' => 'Please select Document Type',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                Session::flash('error', 'Something went wrong, Please try after sometimes!');
                return redirect()->back()->withErrors($validator)->withInput();
            }

            try {

                $risk =  $this->hazard->updates($id);
                $this->hazardlist->updates($id);

                Session::flash('success', 'HIRADC Updated successfully!');
            } catch (Exception $ex) {

                Session::flash('error', 'Something went wrong, Please try after sometimes!');
            }

            return redirect(admin_url('hiradc/hiradc/list'));
        } catch (Exception $ex) {

            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('hiradc/hiradc/list'));
        }
    }


    public function ApproveReject(Request $request)
    {
        try {

            $id = decryptId($request->id);
            if (Auth::check()) {

                $risk = $this->hazard->selectOne($id);
                $riskdetails = $this->hazardlist->getwhere(['hazard_id' => $id]);

                $documentdetails = $this->document->get();
                $processtypeList = $this->preocestype->get();
                $processtypeDetailsdata = $this->processtypedetails->get();

                $processtypedetails = [];

                foreach ($processtypeDetailsdata as $processtypeDetail) {
                    $processtypedetails[$processtypeDetail->process_type_id][] = $processtypeDetail;
                }

                $hiradc_status_log =  $this->statuslog->getlist($id);

                $data = array(
                    'risk' =>  $risk,
                    'riskdetails' =>  $riskdetails,
                    'documentdetails' =>  $documentdetails,
                    'processtypeList' =>  $processtypeList,
                    'processtypedetails' =>  $processtypedetails,
                    'approve' => 'YES',
                    'hiradc_status_log' =>  $hiradc_status_log,
                );
            }
            return view('hiradc.hiradc.view', $data);
        } catch (Exception $ex) {
            report($ex);
        }
    }

    public function  SupervisorApproveRejectSubmit(Request $request)
    {

        try {

            $id = decryptId($request->id);

            if ($request->has('approve')) {
                $tostatus = HIRADC_STATUS_APPROVED;
            }

            if ($request->has('reject')) {
                $tostatus = HIRADC_STATUS_REJECTED;
            }

            $loginsert = array(
                'risk_id' =>  $id,
                'from_status' => 1,
                'to_status' => $tostatus,
                'status_description' => $request->remarks,
                'created_by' => Auth::id(),
            );

            $this->hazard->where('id', $id)->update(['approve_status' => $tostatus]);

            if ($tostatus == HIRADC_STATUS_APPROVED) {
                $this->hazardlist->where('hazard_id', $id)->update(['hazard_status' => HIRADC_ACTIVE_STATUS]);
            }

            $this->statuslog->create($loginsert);

            Session::flash('success', 'HIRADC status updated successfully!');
            return redirect(admin_url('hiradc/hiradc/list'));
        } catch (Exception $ex) {

            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('hiradc/hiradc/list'));
        }
    }

    public function Delete(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $risk =  $this->hazard->deleterecord($id);
            $this->hazardlist->deleterecord($id);

            return response()->json(['status' => 'success', 'msg' => 'HIRADC Record deleted successfully'], 200);
        } catch (Exception $ex) {
            dd($ex);
            return response()->json(['status' => 'error', 'msg' => 'Please try after some time'], 406);
        }
    }

    public function ExportExcel(Request $request)
    {

        try {

            $allData = $this->hazard->exportdata();


            $header = [
                'No.',
                'Risk ID',
                'Document Type',
                'Document Sub-Type',
                'Document Type Category',
                'Process Type',
                'Process Type Details',
                'Activity Number',
                'Remarks',
                'Created By',
                'Status',
                'Created Date',
            ];

            $i = 1;
            foreach ($allData as $data) {

                if ($data->approve_status == HIRADC_STATUS_PENDING) {
                    $status = 'Pending';
                } else if ($data->approve_status == HIRADC_STATUS_APPROVED) {
                    $status = 'Approved';
                } else if ($data->approve_status == HIRADC_STATUS_REJECTED) {
                    $status = 'Rejected';
                }

                $export = [];
                $export['No.'] =  $i;
                $export['Risk ID'] =  $data->risk_id;
                $export['Document Type'] =  $data->document_name;
                $export['Document Sub-Type'] =  $data->documenttype_name;
                $export['Document Type Category'] =  $data->category_name;
                $export['Process Type'] =  $data->process_type_name;
                $export['Process Type Details'] =  getMultipleValue('hiradc_master_process_type_details', $data->process_type_details, 'id', 'sub_type_name');
                $export['Activity Number'] =  $data->activity_number;
                $export['remarks'] =  $data->remarks;
                $export['Created By'] =  getUsername($data->created_by);
                $export['Status'] =   $status;
                $export['Created Date'] =  Displaydateformat($data->created_at);

                $exportData[] = $export;

                $i++;
            }

            $writer = SimpleExcelWriter::streamDownload('HIRADC Details.xlsx')
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

            $allData = $this->hazard->exportdata();

            $header = [
                'No.',
                'Risk ID',
                'Document Type',
                'Document Sub-Type',
                'Document Type Category',
                'Process Type',
                'Process Type Details',
                'Activity Number',
                'Remarks',
                'Created By',
                'Status',
                'Created Date',
            ];

            $data = array(
                'header' => $header,
                'content' => $allData,
                'pagetitle' => "HIRADC Details",
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

            $view = view('hiradc.hiradc.pdf', $data);
            $html = $view->render();



            $mpdf->WriteHTML($html);

            $filename = "HIRADC Details.pdf";
            $mpdf->Output($filename, 'D');
        } catch (Exception $ex) {
            dd($ex);
            report($ex);
        }
    }
}
