<?php

namespace App\Http\Controllers\Incident;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\SimpleExcel\SimpleExcelWriter;

use PDF;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

use App\Models\Incident\IncidentCategory;
use App\Models\Incident\IncidentItem;
use App\Models\Incident\IncidentSubItem;

class IncidentSubItemController extends Controller
{

    private $incidentcategory;
    private $incidentitem;
    private $incidentsubitem;

    public function __construct()
    {

        $this->incidentcategory = new IncidentCategory();
        $this->incidentitem = new IncidentItem();
        $this->incidentsubitem = new IncidentSubItem();

    }

    public function index(Request $request)
    {

        if (Auth::check()) {
            if ($request->ajax()) {
                try {

                    $data =  $this->incidentsubitem->list();

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
                            $btn .= '<a href="' . admin_url('incident/master/subitem/edit/' . encryptId($row->id)) . '" class="popupwindow " title="Edit"><i class="fa-solid fa-pen-to-square"></i> ';
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

        return view('incident.master.subitem.list', $data);
    }

    public function Add(Request $request)
    {
        try {

            $categoryList = $this->incidentcategory->get();
            $data = array(
                'categoryList' => $categoryList
            );
            return view('incident.master.subitem.add', $data);

        } catch (Exception $ex) {
            report($ex);
        }
    }

    public function Store(Request $request)
    {
        try {

            $rules = [
                'category' => 'required',
                'item' => 'required',
                'subitem_name' => 'required',
            ];
            $messages = [
                'category.required' => 'Please select Category',
                'item.required' => 'Please select Ite,',
                'subitem_name.required' => 'Please enter Sub Item Name',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {

                return redirect()->back()->withErrors($validator)->withInput();
            }

            try {

                $this->incidentsubitem->store();

                Session::flash('success', 'Sub Item added successfully!');
            } catch (Exception $ex) {
                dd($ex);
                Session::flash('error', 'Something went wrong, Please try after sometimes!');
            }

            return redirect(admin_url('incident/master/subitem/list'));
        } catch (Exception $ex) {

            dd($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('incident/master/subitem/list'));
        }
    }

    public function View(Request $request)
    {
        try {
            $id = decryptId($request->id);
            if (Auth::check()) {
                $company = $this->incidentsubitem->selectOne($id);

                $data = array(
                    'company' => $company,
                );
            }
            return view('incident.master.subitem.view', $data);
        } catch (Exception $ex) {
            report($ex);
        }
    }

    public function Edit(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $categoryList =$this->incidentcategory->get();
            $subitem = $this->incidentsubitem->selectOne($id);
            $itemList = $this->incidentitem->getWhere( [ 'category_id' => $subitem->category_id ] );

            $data = array(
                'subitem' => $subitem,
                'categoryList' => $categoryList,
                'itemList' => $itemList,
            );

            return view('incident.master.subitem.edit', $data);

        } catch (Exception $ex) {

            dd($ex);
        }
    }

    public function Update(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $rules = [
                'category' => 'required',
                'item' => 'required',
                'subitem_name' => 'required',
            ];
            $messages = [
                'category.required' => 'Please select Category',
                'item.required' => 'Please select Ite,',
                'subitem_name.required' => 'Please enter Sub Item Name',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $this->incidentsubitem->updates($id);

            Session::flash('success', 'Sub Item updated successfully!');
            return redirect(admin_url('incident/master/subitem/list'));
        } catch (Exception $ex) {
            dd($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('incident/master/subitem/list'));
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

            $this->incidentsubitem->statuschange($id);

            return response()->json(['status' => 'success', 'msg' => 'Sub Item status changed'], 200);
        } catch (Exception $ex) {

            return response()->json(['status' => 'error', 'msg' => 'Please try after some time'], 406);
        }
    }

    public function Delete(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $this->incidentsubitem->deleterecord($id);

            return response()->json(['status' => 'success', 'msg' => 'Sub Item deleted successfully'], 200);
        } catch (Exception $ex) {

            return response()->json(['status' => 'error', 'msg' => 'Please try after some time'], 406);
        }
    }

    public function ExportExcel(Request $request)
    {

        try {

            $allData = $this->incidentsubitem->exportdata();

            $header = [
                'No.',
                'Inspection Type',
                'Category Name',
                'Item Name',
                'Created Date',
            ];

            $i = 1;
            foreach ($allData as $data) {

                $export = [];
                $export['No.'] =  $i;
                $export['Inspection Type'] =  $data->inspectiontype_name;
                $export['Category Name'] =  $data->category_name;
                $export['Item Email'] =  $data->item_name;
                $export['Created Date'] =  Displaydateformat($data->created_at);

                $exportData[] = $export;

                $i++;
            }

            $writer = SimpleExcelWriter::streamDownload('Sub Item.xlsx')
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

            $allData = $this->incidentsubitem->exportdata();

            $header = [
                'No.',
                'Inspection Type',
                'Category Name',
                'Item Name',
                'Created Date',
            ];

            $data = array(
                'header' => $header,
                'content' => $allData,
                'pagetitle' => "Sub Item Details",
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

            $view = view('incident.master.subitem.pdf', $data);
            $html = $view->render();



            $mpdf->WriteHTML($html);

            $filename = "Sub Item.pdf";
            $mpdf->Output($filename, 'D');
        } catch (Exception $ex) {

            report($ex);
        }
    }



}
