<?php

namespace App\Http\Controllers\Inspection;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\SimpleExcel\SimpleExcelWriter;

use PDF;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

use App\Models\User;
use App\Models\Inspection\InspectionType;
use App\Models\Inspection\ChecklistCategory;
use App\Models\Inspection\ChecklistItem;


class ChecklistCategoryController extends Controller
{

    private $checklistcategory;
    private $inspectiontype;
    private $checklistitem;

    public function __construct()
    {

        $this->inspectiontype = new InspectionType();
        $this->checklistcategory = new ChecklistCategory();
        $this->checklistitem = new ChecklistItem();
    }

    public function index(Request $request)
    {

        if (Auth::check()) {
            if ($request->ajax()) {
                try {

                    $data =  $this->checklistcategory->list();

                    $datatables = Datatables::of($data['data'])
                        ->addIndexColumn()

                        ->addColumn('action', function ($row) {
                            $btn = '';

                            $btn .= '<a href="' . admin_url('inspection/master/checklistcategory/edit/' . encryptId($row->id)) . '" class="" title="Edit"><i class="fa-solid fa-pen-to-square"></i> ';
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
                    report($ex);
                    return response()->json(['status' => 'error', 'msg' => 'Please try after some time'], 406);
                }
            }
        }

        $data = array();

        return view('inspection.master.category.list', $data);
    }

    public function Add(Request $request)
    {

        try {

            $inspectiontypeList = $this->inspectiontype->get();

            $data = array(
                'inspectiontypeList' => $inspectiontypeList,
            );
            return view('inspection.master.category.add', $data);
        } catch (Exception $ex) {
            report($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('inspection/master/checklistcategory/list'));
        }
    }

    public function Store(Request $request)
    {
        try {

            $rules = [
                'inspectiontype' => 'required',
                'category_name' => 'required',
            ];
            $messages = [
                'inspectiontype.required' => 'Please enter Location ID',
                'category_name.required' => 'Please enter Location Name',


            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {

                Session::flash('error', 'Something went wrong, Please try after sometimes!');
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $category = $this->checklistcategory->store();

            $this->checklistitem->store($category);

            Session::flash('success', 'Checklist Category added successfully!');
            return redirect(admin_url('inspection/master/checklistcategory/list'));
        } catch (Exception $ex) {
            report($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('inspection/master/checklistcategory/list'));
        }
    }

    public function View(Request $request)
    {
        try {
            $id = decryptId($request->id);
            if (Auth::check()) {
                $company = $this->checklistcategory->selectOne($id);

                $data = array(
                    'company' => $company,
                );
            }
            return view('inspection.master.category.view', $data);
        } catch (Exception $ex) {
            report($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('inspection/master/checklistcategory/list'));
        }
    }

    public function Edit(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $inspectiontypeList =  $this->inspectiontype->get();

            $category = $this->checklistcategory->selectOne($id);
            $where = array(
                'category_id' => $id
            );
            $itemdetails = $this->checklistitem->getwhere($where);
            $data = array(
                'category' => $category,
                'inspectiontypeList' => $inspectiontypeList,
                'itemdetails' => $itemdetails,
            );


            return view('inspection.master.category.edit', $data);
        } catch (Exception $ex) {
            report($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('inspection/master/checklistcategory/list'));
        }
    }

    public function Update(Request $request)
    {
        try {


            $id = decryptId($request->id);

            $rules = [
                'inspectiontype' => 'required',
                'category_name' => 'required',
            ];
            $messages = [
                'inspectiontype.required' => 'Please enter Location ID',
                'category_name.required' => 'Please enter Location Name',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                Session::flash('error', 'Something went wrong, Please try after sometimes!');
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $this->checklistcategory->updates($id);

            $category = $this->checklistcategory->find($id);
            $this->checklistitem->updates($category);

            Session::flash('success', 'Checklist Category updated successfully!');
            return redirect(admin_url('inspection/master/checklistcategory/list'));
        } catch (Exception $ex) {

            report($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('inspection/master/checklistcategory/list'));
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

            $this->checklistcategory->statuschange($id);

            return response()->json(['status' => 'success', 'msg' => 'Checklist Category status changed'], 200);
        } catch (Exception $ex) {

            return response()->json(['status' => 'error', 'msg' => 'Please try after some time'], 406);
        }
    }

    public function Delete(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $this->checklistcategory->deleterecord($id);

            return response()->json(['status' => 'success', 'msg' => 'Checklist Category deleted successfully'], 200);
        } catch (Exception $ex) {

            return response()->json(['status' => 'error', 'msg' => 'Please try after some time'], 406);
        }
    }



    public function ExportExcel(Request $request)
    {

        try {

            $allData = $this->checklistcategory->exportdata();

            $header = [
                'No.',
                'Inspection Type Name',
                'Category Name',
                'Created Date',
            ];

            $i = 1;
            foreach ($allData as $data) {

                $export = [];
                $export['No.'] =  $i;
                $export['Inspection Type Name'] =  $data->inspectiontype_name;
                $export['Category Name'] =  $data->category_name;
                $export['Created Date'] =  Displaydateformat($data->created_at);

                $exportData[] = $export;

                $i++;
            }

            $writer = SimpleExcelWriter::streamDownload('Checklist Category.xlsx')
                ->addHeader($header)
                ->addRows(
                    $exportData
                );
        } catch (Exception $ex) {

            report($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('inspection/master/checklistcategory/list'));
        }
    }

    public function ExportPdf(Request $request)
    {

        try {

            $allData = $this->checklistcategory->exportdata();

            $header = [
                'No.',
                'Inspection Type Name',
                'Category Name',
                'Created Date',
            ];

            $data = array(
                'header' => $header,
                'content' => $allData,
                'pagetitle' => "Inspection Checklist Category",
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

            $view = view('inspection.master.category.pdf', $data);
            $html = $view->render();



            $mpdf->WriteHTML($html);

            $filename = "Checklist Category.pdf";
            $mpdf->Output($filename, 'D');
        } catch (Exception $ex) {

            report($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('inspection/master/checklistcategory/list'));
        }
    }

    public function list(Request $request)
    {

        $activityid = decryptId($request->activityid);

        $activity = $this->checklistcategory->ajaxList($activityid);

        return response()->json($activity);
    }
}
