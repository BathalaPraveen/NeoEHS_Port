<?php

namespace App\Http\Controllers\Chemical;

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
use App\Models\Chemical\ChemicalCategory;
use App\Models\Chemical\ChemicalItem;


class ItemController extends Controller
{

    private $item;

    public function __construct()
    {

        $this->item = new ChemicalItem();
    }

    public function index(Request $request)
    {

        if (Auth::check()) {
            if ($request->ajax()) {
                try {

                    $data =  $this->item->list();

                    $datatables = Datatables::of($data['data'])
                        ->addIndexColumn()

                        ->addColumn('action', function ($row) {
                            $btn = '';
                            $btn .= '<a href="' . admin_url('chemical/master/item/edit/' . encryptId($row->id)) . '" class="popupwindow" title="Edit"><i class="fa-solid fa-pen-to-square"></i> ';
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

        return view('chemical.master.item.list', $data);
    }

    public function Add(Request $request)
    {

        try {

            $categoryList =  ChemicalCategory::get();

            $data = array(
                'categoryList' => $categoryList,
            );
            return view('chemical.master.item.add', $data);

        } catch (Exception $ex) {
            report($ex);
        }
    }

    public function Store(Request $request)
    {
        try {

            $rules = [
                'category' => 'required',
                'item_name' => 'required',
            ];
            $messages = [
                'category.required' => 'Please enter Chemical Item ID',
                'item_name.required' => 'Please enter Chemical Item Name',


            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                Session::flash('error', 'Something went wrong, Please try after sometimes!');
                return redirect()->back()->withErrors($validator)->withInput();
            }

            try {

                $this->item->store();

                Session::flash('success', 'Chemical Item added successfully!');
            } catch (Exception $ex) {


                Session::flash('error', 'Something went wrong, Please try after sometimes!');
            }

            return redirect(admin_url('chemical/master/item/list'));
        } catch (Exception $ex) {


            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('chemical/master/item/list'));
        }
    }

    public function View(Request $request)
    {
        try {
            $id = decryptId($request->id);
            if (Auth::check()) {
                $company = $this->item->selectOne($id);

                $data = array(
                    'company' => $company,
                );
            }
            return view('chemical.master.item.view', $data);
        } catch (Exception $ex) {
            report($ex);
        }
    }

    public function Edit(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $categoryList =  ChemicalCategory::get();

            $item = $this->item->selectOne($id);
            $data = array(
                'item' => $item,
                'categoryList' => $categoryList,
            );


            return view('chemical.master.item.edit', $data);
        } catch (Exception $error) {
            report($error->getMessage());
        }
    }

    public function Update(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $rules = [
                'category' => 'required',
                'item_name' => 'required',
            ];
            $messages = [
                'category.required' => 'Please enter Chemical Item ID',
                'item_name.required' => 'Please enter Chemical Item Name',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                Session::flash('error', 'Something went wrong, Please try after sometimes!');
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $this->item->updates($id);

            Session::flash('success', 'Chemical Item updated successfully!');
            return redirect(admin_url('chemical/master/item/list'));
        } catch (Exception $ex) {

            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('chemical/master/item/list'));
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

            $view = view('chemical.master.item.pdf', $data);
            $html = $view->render();



            $mpdf->WriteHTML($html);

            $filename = "Chemical Item.pdf";
            $mpdf->Output($filename, 'D');
        } catch (Exception $ex) {

            report($ex);
        }
    }

    public function list(Request $request){

        $categoryid = decryptId($request->categoryid);

        $category = $this->item->ajaxList($categoryid);

        return response()->json($category);

    }

}
