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




class DocumentTypeController extends Controller
{

    private $document;
    private $documenttype;

    public function __construct()
    {

        $this->document = new Document();
        $this->documenttype = new DocumentType();
    }

    public function index(Request $request)
    {

        if (Auth::check()) {
            if ($request->ajax()) {
                try {

                    $data =  $this->documenttype->list();

                    $datatables = Datatables::of($data['data'])
                        ->addIndexColumn()

                        ->addColumn('action', function ($row) {
                            $btn = '';
                            $btn .= '<a href="' . admin_url('hiradc/master/documenttype/edit/' . encryptId($row->id)) . '" class="popupwindow" title="Edit"><i class="fa-solid fa-pen-to-square"></i> ';
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

                    return response()->json(['status' => 'error', 'msg' => 'Please try after some time',$ex], 406);
                }
            }
        }

        $data = array();

        return view('hiradc.master.documenttype.list', $data);
    }

    public function Add(Request $request)
    {

        try {

            $documentList =  $this->document->get();

            $data = array(
                'documentList' => $documentList,
            );

            return view('hiradc.master.documenttype.add', $data);

        } catch (Exception $ex) {
            report($ex);
        }
    }

    public function Store(Request $request)
    {
        try {

            $rules = [
                'document' => 'required',
                'documenttype_name' => 'required',
            ];
            $messages = [
                'document.required' => 'Please select Document',
                'documenttype_name.required' => 'Please enter Document Type Name',


            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                Session::flash('error', 'Something went wrong, Please try after sometimes!');
                return redirect()->back()->withErrors($validator)->withInput();
            }

            try {

                $this->documenttype->store();

                Session::flash('success', 'Document Type added successfully!');
            } catch (Exception $ex) {


                Session::flash('error', 'Something went wrong, Please try after sometimes!');
            }

            return redirect(admin_url('hiradc/master/documenttype/list'));
        } catch (Exception $ex) {


            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('hiradc/master/documenttype/list'));
        }
    }

    public function View(Request $request)
    {
        try {
            $id = decryptId($request->id);
            if (Auth::check()) {
                $documenttype = $this->documenttype->selectOne($id);

                $data = array(
                    'documenttype' => $documenttype,
                );
            }
            return view('hiradc.master.documenttype.view', $data);
        } catch (Exception $ex) {
            report($ex);
        }
    }

    public function Edit(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $documentList =  $this->document->get();

            $item = $this->documenttype->selectOne($id);
            $data = array(
                'item' => $item,
                'documentList' => $documentList,
            );


            return view('hiradc.master.documenttype.edit', $data);
        } catch (Exception $error) {
            report($error->getMessage());
        }
    }

    public function Update(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $rules = [
                'document' => 'required',
                'documenttype_name' => 'required',
            ];
            $messages = [
                'document.required' => 'Please enter Document Type ID',
                'documenttype_name.required' => 'Please enter Document Type Name',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                Session::flash('error', 'Something went wrong, Please try after sometimes!');
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $this->documenttype->updates($id);

            Session::flash('success', 'Document Type updated successfully!');
            return redirect(admin_url('hiradc/master/documenttype/list'));
        } catch (Exception $ex) {

            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('hiradc/master/documenttype/list'));
        }
    }

    public function Delete(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $this->documenttype->deleterecord($id);

            return response()->json(['status' => 'success', 'msg' => 'Document Type deleted successfully'], 200);
        } catch (Exception $ex) {

            return response()->json(['status' => 'error', 'msg' => 'Please try after some time'], 406);
        }
    }

    public function ExportExcel(Request $request)
    {

        try {

            $allData = $this->documenttype->exportdata();

            $header = [
                'No.',
                'document Name',
                'Item Name',
                'Created Date',
            ];

            $i = 1;
            foreach ($allData as $data) {

                $export = [];
                $export['No.'] =  $i;
                $export['document Name'] =  $data->document_name;
                $export['Item Name'] =  $data->documenttype_name;
                $export['Created Date'] =  Displaydateformat($data->created_at);

                $exportData[] = $export;

                $i++;
            }

            $writer = SimpleExcelWriter::streamDownload('Document Type.xlsx')
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

            $allData = $this->documenttype->exportdata();

            $header = [
                'No.',
                'document Name',
                'Item Name',
                'Created Date',
            ];

            $data = array(
                'header' => $header,
                'content' => $allData,
                'pagetitle' => "Document Type Details",
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

            $view = view('hiradc.master.documenttype.pdf', $data);
            $html = $view->render();



            $mpdf->WriteHTML($html);

            $filename = "Document Type.pdf";
            $mpdf->Output($filename, 'D');
        } catch (Exception $ex) {

            report($ex);
        }
    }

    public function list(Request $request){

        $documentid = decryptId($request->documentId);

        $document = $this->documenttype->dataList($documentid);

        return response()->json($document);

    }

}
