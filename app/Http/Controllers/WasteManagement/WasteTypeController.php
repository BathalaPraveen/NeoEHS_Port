<?php

namespace App\Http\Controllers\WasteManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\SimpleExcel\SimpleExcelWriter;
use Illuminate\Support\Facades\Auth;

use PDF;
use Session;
use Exception;
use DataTables;


use App\Models\User;
use App\Models\WasteManagement\WasteType;


class WasteTypeController extends Controller
{

    private $wastetype;

    public function __construct()
    {

        $this->wastetype = new WasteType();
    }

    public function index(Request $request)
    {

        if (Auth::check()) {
            if ($request->ajax()) {
                try {

                    $data =  $this->wastetype->list();

                    $datatables = Datatables::of($data['data'])
                        ->addIndexColumn()
                        ->addColumn('action', function ($row) {
                            $btn = '';
                            $btn .= '<a href="' . admin_url('wastemanagement/master/wastetype/edit/' . encryptId($row->id)) . '" class="popupwindow" title="Edit"><i class="fa-solid fa-pen-to-square"></i> ';
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

                    return response()->json(['status' => 'error', 'msg' => 'Please try after some time', $ex], 406);
                }
            }
        }

        $data = array();

        return view('wastemanagement.master.wastetype.list', $data);
    }


    public function Add(Request $request)
    {

        try {

            $data = array();
            return view('wastemanagement.master.wastetype.add', $data);
        } catch (Exception $ex) {
            report($ex);
        }
    }

    public function Store(Request $request)
    {
        try {

            $rules = [
                'type_id' => 'required',
                'type_name' => 'required',
            ];
            $messages = [
                'type_id.required' => 'Please enter Waste Type ID',
                'type_name.required' => 'Please enter Waste Type Name',


            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                Session::flash('error', 'Something went wrong, Please try after sometimes!');
                return redirect()->back()->withErrors($validator)->withInput();
            }

            try {

                $this->wastetype->store();

                Session::flash('success', 'Waste Type added successfully!');
            } catch (Exception $ex) {


                Session::flash('error', 'Something went wrong, Please try after sometimes!');
            }

            return redirect(admin_url('wastemanagement/master/wastetype/list'));
        } catch (Exception $ex) {

            report($ex);

            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('wastemanagement/master/wastetype/list'));
        }
    }



    public function Edit(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $wastetype = $this->wastetype->selectOne($id);
            $data = array(
                'wastetype' => $wastetype,

            );


            return view('wastemanagement.master.wastetype.edit', $data);
        } catch (Exception $error) {
            report($error->getMessage());
        }
    }

    public function Update(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $rules = [
                'type_id' => 'required',
                'type_name' => 'required',
            ];
            $messages = [
                'type_id.required' => 'Please enter Waste Type ID',
                'type_name.required' => 'Please enter Waste Type Name',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                Session::flash('error', 'Something went wrong, Please try after sometimes!');
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $this->wastetype->updates($id);

            Session::flash('success', 'Waste Type updated successfully!');
            return redirect(admin_url('wastemanagement/master/wastetype/list'));
        } catch (Exception $ex) {

            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('wastemanagement/master/wastetype/list'));
        }
    }

    public function Delete(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $this->wastetype->deleterecord($id);

            return response()->json(['status' => 'success', 'msg' => 'Waste Type deleted successfully'], 200);
        } catch (Exception $ex) {

            return response()->json(['status' => 'error', 'msg' => 'Please try after some time'], 406);
        }
    }



    public function ExportExcel(Request $request)
    {

        try {

            $allData = $this->wastetype->exportdata();

            $header = [
                'No.',
                'Waste Type ID',
                'Waste Type Name',
                'Created Date',
            ];

            $i = 1;
            foreach ($allData as $data) {

                $export = [];
                $export['No.'] =  $i;
                $export['Waste Type ID'] =  $data->wastetype_id;
                $export['Waste Type Name'] =  $data->wastetype_name;
                $export['Created Date'] =  Displaydateformat($data->created_at);

                $exportData[] = $export;

                $i++;
            }

            $writer = SimpleExcelWriter::streamDownload('Waste Type.xlsx')
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

            $allData = $this->wastetype->exportdata();

            $header = [
                'No.',
                'Waste Type ID',
                'Waste Type Name',
                'Created Date',
            ];

            $data = array(
                'header' => $header,
                'content' => $allData,
                'pagetitle' => "Waste Type Details",
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

            $view = view('wastemanagement.master.wastetype.pdf', $data);
            $html = $view->render();



            $mpdf->WriteHTML($html);

            $filename = "Waste Type.pdf";
            $mpdf->Output($filename, 'D');
        } catch (Exception $ex) {

            report($ex);
        }
    }
}
