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


use App\Models\HIRADC\Document;
use App\Models\HIRADC\DocumentType;
use App\Models\HIRADC\Category;

class DocuemntTypeCategoryController extends Controller
{

    private $document;
    private $documenttype;
    private $category;

    public function __construct()
    {

        $this->document = new Document();
        $this->documenttype = new DocumentType();
        $this->category = new Category();

    }

    public function index(Request $request)
    {

        if (Auth::check()) {
            if ($request->ajax()) {
                try {

                    $data =  $this->category->list();

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
                            $btn .= '<a href="' . admin_url('hiradc/master/documentcategory/edit/' . encryptId($row->id)) . '" class="popupwindow " title="Edit"><i class="fa-solid fa-pen-to-square"></i> ';
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

        return view('hiradc.master.category.list', $data);
    }

    public function Add(Request $request)
    {

        try {

            $documentList = $this->document->get();
            $data = array(
                'documentList' => $documentList
            );
            return view('hiradc.master.category.add', $data);
        } catch (Exception $ex) {
            report($ex);
        }
    }

    public function Store(Request $request)
    {
        try {

            $rules = [
                'document' => 'required',
                'document_type' => 'required',
                'category_name' => 'required',
            ];
            $messages = [
                'document.required' => 'Please select Document',
                'category.required' => 'Please select Document Type',
                'category_name.required' => 'Please enter Category Name',

            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {

                return redirect()->back()->withErrors($validator)->withInput();
            }

            try {

                $this->category->store();

                Session::flash('success', 'Document Category added successfully!');
            } catch (Exception $ex) {

                Session::flash('error', 'Something went wrong, Please try after sometimes!');
            }

            return redirect(admin_url('hiradc/master/documentcategory/list'));
        } catch (Exception $ex) {


            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('hiradc/master/documentcategory/list'));
        }
    }

    public function View(Request $request)
    {
        try {
            $id = decryptId($request->id);
            if (Auth::check()) {
                $company = $this->category->selectOne($id);

                $data = array(
                    'company' => $company,
                );
            }
            return view('hiradc.master.category.view', $data);
        } catch (Exception $ex) {
            report($ex);
        }
    }

    public function Edit(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $documentList =$this->document->get();
            $category = $this->category->selectOne($id);
            $documenttypeList = $this->documenttype->getWhere($category->document_id);

            $data = array(
                'category' => $category,
                'documentList' => $documentList,
                'documenttypeList' => $documenttypeList,
            );


            return view('hiradc.master.category.edit', $data);
        } catch (Exception $ex) {

        }
    }

    public function Update(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $rules = [
                'document' => 'required',
                'document_type' => 'required',
                'category_name' => 'required',
            ];
            $messages = [
                'document.required' => 'Please select Document',
                'category.required' => 'Please select Document Type',
                'category_name.required' => 'Please enter Category Name',

            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                dd($validator);
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $this->category->updates($id);

            Session::flash('success', 'Document Category updated successfully!');
            return redirect(admin_url('hiradc/master/documentcategory/list'));
        } catch (Exception $ex) {

            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('hiradc/master/documentcategory/list'));
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

            $this->category->statuschange($id);

            return response()->json(['status' => 'success', 'msg' => 'Document Category status changed'], 200);
        } catch (Exception $ex) {

            return response()->json(['status' => 'error', 'msg' => 'Please try after some time'], 406);
        }
    }

    public function Delete(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $this->category->deleterecord($id);

            return response()->json(['status' => 'success', 'msg' => 'Document Category deleted successfully'], 200);
        } catch (Exception $ex) {

            return response()->json(['status' => 'error', 'msg' => 'Please try after some time'], 406);
        }
    }

    public function ExportExcel(Request $request)
    {

        try {

            $allData = $this->category->exportdata();

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
                $export['Inspection Type'] =  $data->document_name;
                $export['Category Name'] =  $data->category_name;
                $export['Item Email'] =  $data->category_name;
                $export['Created Date'] =  Displaydateformat($data->created_at);

                $exportData[] = $export;

                $i++;
            }

            $writer = SimpleExcelWriter::streamDownload('Document Category.xlsx')
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

            $allData = $this->category->exportdata();

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
                'pagetitle' => "Document Category Details",
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

            $view = view('hiradc.master.category.pdf', $data);
            $html = $view->render();



            $mpdf->WriteHTML($html);

            $filename = "Document Category.pdf";
            $mpdf->Output($filename, 'D');
        } catch (Exception $ex) {

            report($ex);
        }
    }


    public function list(Request $request)
    {

        $documenttypeid = decryptId($request->docuenttypecategory);

        $documenttype = $this->category->ajaxList($documenttypeid);

        return response()->json($documenttype);
    }



}
