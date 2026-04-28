<?php

namespace App\Http\Controllers\WasteManagement;

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
use App\Models\Master\Company;
use App\Models\Master\Location;

use App\Models\WasteManagement\WasteType;
use App\Models\WasteManagement\DisposalType;
use App\Models\WasteManagement\WasteList;
use App\Models\WasteManagement\WasteListDetails;
use App\Models\WasteManagement\WasteStatus;
use App\Models\WasteManagement\WasteStatusLog;

class WasteController extends Controller
{
    private $company;
    private $location;
    private $wastetype;
    private $disposaltype;
    private $wastelist;
    private $wastelistdetails;
    private $status;
    private $statuslog;

    public function __construct()
    {

        $this->wastetype = new WasteType();
        $this->disposaltype = new DisposalType();
        $this->wastelist = new WasteList();
        $this->wastelistdetails = new WasteListDetails();
        $this->company = new Company();
        $this->location = new Location();
        $this->status = new WasteStatus();
        $this->statuslog = new WasteStatusLog();
    }

    public function index(Request $request)
    {

        if (Auth::check()) {
            if ($request->ajax()) {
                try {

                    $data =  $this->wastelist->list();

                    $datatables = Datatables::of($data['data'])
                        ->addIndexColumn()
                        ->addColumn('created_date', function ($row) {
                            return Displaydateformat($row->created_at);
                        })
                        ->addColumn('waste_status', function ($row) {
                            $text = wasteStatus($row->waste_disposal_status);
                            return $text;
                        })

                        ->addColumn('action', function ($row) {
                            $btn = '';
                            $btn .= '<a href="' . admin_url('wastemanagement/waste/view/' . encryptId($row->id)) . '"  title="View"><i class="fa-solid fa-eye"></i> ';
                            if ($row->waste_disposal_status == WASTE_STATUS_GHSE_REJECTED && ($row->created_by || isAdmin())) {
                                $btn .= '<a href="' . admin_url('wastemanagement/waste/edit/' . encryptId($row->id)) . '"  title="Edit"><i class="fa-solid fa-pen-to-square"></i> ';
                            }
                            if ($row->waste_disposal_status == WASTE_STATUS_GHSE_PENDING && (CheckUserRole(ROLE_GHSE_APPROVER) || isAdmin())) {
                                $btn .= '<a href="' . admin_url('wastemanagement/waste/approvereject/' . encryptId($row->id)) . '"   class="" title="Approve / Reject"><i class="fa-solid fa-check-to-slot"></i></a> ';
                            }
                            $btn .= '<a href="javascript:void(0);"  data-id="' . encryptId($row->id) . '"  class="recordDelete" title="Delete"><i class="fa-solid fa-trash text-danger" ></i></i></a> ';
                            return $btn;
                        })
                        ->rawColumns(['action', 'created_date', 'created_by', 'status', 'waste_status'])
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

        $data = array();

        return view('wastemanagement.waste.list', $data);
    }

    public function Add(Request $request)
    {

        try {

            $companyList =  $this->company->getAllCompany();
            $wastetype = $this->wastetype->get();
            $disposaltype = $this->disposaltype->get();
            $locationList =  $this->location->getAllLocation();

            $data = array(

                'companyList' => $companyList,
                'wastetypeList' => $wastetype,
                'disposaltypeList' => $disposaltype,
                'locationList' => $locationList,

            );
            return view('wastemanagement.waste.add', $data);
        } catch (Exception $ex) {
            report($ex);
        }
    }

    public function Store(Request $request)
    {
        try {

            $rules = [
                'company' => 'required',
                'location' => 'required',
            ];
            $messages = [
                'company.required' => 'Please select Company',
                'location.required' => 'Please select Location',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {

                Session::flash('error', 'Something went wrong, Please try after sometimes!');
                return redirect()->back()->withErrors($validator)->withInput();
            }

            try {

                $list =  $this->wastelist->store();
                $this->wastelistdetails->store($list->id);

                Session::flash('success', 'Waste List added successfully!');
            } catch (Exception $ex) {

                Session::flash('error', 'Something went wrong, Please try after sometimes!');
            }

            return redirect(admin_url('wastemanagement/waste/list'));
        } catch (Exception $ex) {

            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('wastemanagement/waste/list'));
        }
    }

    public function View(Request $request)
    {
        try {
            $id = decryptId($request->id);
            if (Auth::check()) {

                $companyList =  $this->company->get();
                $wastetype = $this->wastetype->get();
                $disposaltype = $this->disposaltype->get();
                $locationList =  $this->location->get();

                $disposaltypeArray = [];
                foreach ($disposaltype as $type) {
                    $disposaltypeArray[$type['id']] = $type['disposaltype_name'];
                }

                $wasteDetails =  $this->wastelist->find($id);
                $wastelistDetails =  $this->wastelistdetails->getwhere(['waste_list_id' => $id]);

                $statuslogs = $this->statuslog->getDetails($id);

                $data = array(
                    'companyList' => $companyList,
                    'wastetypeList' => $wastetype,
                    'disposaltypeList' => $disposaltype,
                    'locationList' => $locationList,
                    'disposaltypeArray' => $disposaltypeArray,
                    'wasteDetails' => $wasteDetails,
                    'wastelistDetails' => $wastelistDetails,
                    'statuslogs' => $statuslogs,
                );
            }
            return view('wastemanagement.waste.view', $data);
        } catch (Exception $ex) {
            report($ex);
        }
    }

    public function Edit(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $companyList =  $this->company->getAllCompany();
            $wastetype = $this->wastetype->get();
            $disposaltype = $this->disposaltype->get();
            $locationList =  $this->location->getAllLocation();

            $disposaltypeArray = [];
            foreach ($disposaltype as $type) {
                $disposaltypeArray[$type['id']] = $type['disposaltype_name'];
            }

            $wasteDetails =  $this->wastelist->find($id);
            $wastelistDetails =  $this->wastelistdetails->getwhere(['waste_list_id' => $id]);

            $data = array(
                'companyList' => $companyList,
                'wastetypeList' => $wastetype,
                'disposaltypeList' => $disposaltype,
                'locationList' => $locationList,
                'disposaltypeArray' => $disposaltypeArray,
                'wasteDetails' => $wasteDetails,
                'wastelistDetails' => $wastelistDetails,
            );

            return view('wastemanagement.waste.edit', $data);
        } catch (Exception $error) {
            report($error->getMessage());
        }
    }

    public function Update(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $rules = [
                'company' => 'required',
                'location' => 'required',
            ];
            $messages = [
                'company.required' => 'Please select Company',
                'location.required' => 'Please select Location',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                Session::flash('error', 'Something went wrong, Please try after sometimes!');
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $this->wastelist->updates($id);
            $this->wastelistdetails->updates($id);


            Session::flash('success', 'Waste Item updated successfully!');
            return redirect(admin_url('wastemanagement/waste/list'));
        } catch (Exception $ex) {

            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('wastemanagement/waste/list'));
        }
    }

    public function Delete(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $this->item->deleterecord($id);

            return response()->json(['status' => 'success', 'msg' => 'Chemical Item deleted successfully'], 200);
        } catch (Exception $ex) {

            return response()->json(['status' => 'error', 'msg' => 'Please try after some time'], 406);
        }
    }

    public function ApproveReject(Request $request)
    {
        try {

            $id = decryptId($request->id);
            if (Auth::check()) {

                $companyList =  $this->company->get();
                $wastetype = $this->wastetype->get();
                $disposaltype = $this->disposaltype->get();
                $locationList =  $this->location->get();

                $disposaltypeArray = [];
                foreach ($disposaltype as $type) {
                    $disposaltypeArray[$type['id']] = $type['disposaltype_name'];
                }

                $wasteDetails =  $this->wastelist->find($id);
                $wastelistDetails =  $this->wastelistdetails->getwhere(['waste_list_id' => $id]);

                $statuslogs = $this->statuslog->getDetails($id);

                $approveReject  = 1;

                $data = array(
                    'companyList' => $companyList,
                    'wastetypeList' => $wastetype,
                    'disposaltypeList' => $disposaltype,
                    'locationList' => $locationList,
                    'disposaltypeArray' => $disposaltypeArray,
                    'wasteDetails' => $wasteDetails,
                    'wastelistDetails' => $wastelistDetails,
                    'statuslogs' => $statuslogs,
                    'approveReject' => $approveReject,
                );
            }
            return view('wastemanagement.waste.view', $data);
        } catch (Exception $ex) {
            report($ex);
        }
    }

    public function ApproveRejectSubmit(Request $request)
    {

        try {

            $id = decryptId($request->id);
            $wastelist = $this->wastelist->find($id);

            if ($request->has('approve')) {
                $is_reject = 0;
                $status = WASTE_STATUS_APPROVED;
            } else if ($request->has('reject')) {
                $is_reject = 1;
                $status = WASTE_STATUS_GHSE_REJECTED;
            }

            $machinery_id = $wastelist->id;

            $insert_array = array(
                'waste_id' => $machinery_id,
                'from_status' => 0,
                'to_status' => $status,
                'is_reject' => $is_reject,
                'remarks' => $request->remarks,
                'approved_by' => Auth::id(),
            );
            $this->statuslog->create($insert_array);

            $this->wastelist->where('id', $id)->update(['waste_disposal_status' => $status]);
            Session::flash('success', 'Waste status changed successfully!');
            return redirect('wastemanagement/waste/list');
        } catch (Exception $ex) {
            report($ex);
            Session::flash('error', 'Please try after sometimes!');
            return redirect('wastemanagement/waste/list');

        }
    }

    public function ExportExcel(Request $request)
    {

        try {

            $allData = $this->item->exportdata();

            $header = [
                'No.',
                'Category Name',
                'Item Name',
                'Created Date',
            ];

            $i = 1;
            foreach ($allData as $data) {

                $export = [];
                $export['No.'] =  $i;
                $export['Category Name'] =  $data->category_name;
                $export['Item Name'] =  $data->item_name;
                $export['Created Date'] =  Displaydateformat($data->created_at);

                $exportData[] = $export;

                $i++;
            }

            $writer = SimpleExcelWriter::streamDownload('Chemical Item.xlsx')
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

            $allData = $this->item->exportdata();

            $header = [
                'No.',
                'Category Name',
                'Item Name',
                'Created Date',
            ];

            $data = array(
                'header' => $header,
                'content' => $allData,
                'pagetitle' => "Chemical Item Details",
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

            $view = view('wastemanagement.waste.pdf', $data);
            $html = $view->render();



            $mpdf->WriteHTML($html);

            $filename = "Chemical Item.pdf";
            $mpdf->Output($filename, 'D');
        } catch (Exception $ex) {

            report($ex);
        }
    }

    public function list(Request $request)
    {

        $categoryid = decryptId($request->categoryid);

        $category = $this->item->ajaxList($categoryid);

        return response()->json($category);
    }
}
