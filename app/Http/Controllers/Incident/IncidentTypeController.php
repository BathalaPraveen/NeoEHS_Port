<?php

namespace App\Http\Controllers\Incident;

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
use App\Models\WasteManagement\DisposalType;


class IncidentTypeController extends Controller
{

    private $disposaltype;

    public function __construct()
    {

        $this->disposaltype = new DisposalType();
    }

    public function index(Request $request)
    {

        if (Auth::check()) {
            if ($request->ajax()) {
                try {

                    $data =  $this->disposaltype->list();

                    $datatables = Datatables::of($data['data'])
                        ->addIndexColumn()
                        ->addColumn('action', function ($row) {
                            $btn = '';
                            $btn .= '<a href="' . admin_url('wastemanagement/master/disposaltype/edit/' . encryptId($row->id)) . '" class="popupwindow" title="Edit"><i class="fa-solid fa-pen-to-square"></i> ';
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

        return view('wastemanagement.master.disposaltype.list', $data);
    }


    public function Add(Request $request)
    {

        try {

            $data = array();
            return view('wastemanagement.master.disposaltype.add', $data);
        } catch (Exception $ex) {
            report($ex);
        }
    }

    public function Store(Request $request)
    {
        try {

            $rules = [
                'disposaltype_name' => 'required',
            ];
            $messages = [
                'disposaltype_name.required' => 'Please enter Disposal Type Name',


            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                Session::flash('error', 'Something went wrong, Please try after sometimes!');
                return redirect()->back()->withErrors($validator)->withInput();
            }

            try {

                $this->disposaltype->store();

                Session::flash('success', 'Disposal Type added successfully!');
            } catch (Exception $ex) {


                Session::flash('error', 'Something went wrong, Please try after sometimes!');
            }

            return redirect(admin_url('wastemanagement/master/disposaltype/list'));
        } catch (Exception $ex) {


            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('wastemanagement/master/disposaltype/list'));
        }
    }



    public function Edit(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $disposaltype = $this->disposaltype->selectOne($id);
            $data = array(
                'disposaltype' => $disposaltype,

            );

            return view('wastemanagement.master.disposaltype.edit', $data);
        } catch (Exception $error) {
            report($error->getMessage());
        }
    }

    public function Update(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $rules = [
                'disposaltype_name' => 'required',
            ];
            $messages = [
                'disposaltype_name.required' => 'Please enter Disposal Type Name',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                Session::flash('error', 'Something went wrong, Please try after sometimes!');
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $this->disposaltype->updates($id);

            Session::flash('success', 'Disposal Type updated successfully!');
            return redirect(admin_url('wastemanagement/master/disposaltype/list'));
        } catch (Exception $ex) {

            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('wastemanagement/master/disposaltype/list'));
        }
    }

    public function Delete(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $this->disposaltype->deleterecord($id);

            return response()->json(['status' => 'success', 'msg' => 'Disposal Type deleted successfully'], 200);
        } catch (Exception $ex) {

            return response()->json(['status' => 'error', 'msg' => 'Please try after some time'], 406);
        }
    }



    public function ExportExcel(Request $request)
    {

        try {

            $allData = $this->disposaltype->exportdata();

            $header = [
                'No.',
                'Disposal Type Name',
                'Created Date',
            ];

            $i = 1;
            foreach ($allData as $data) {

                $export = [];
                $export['No.'] =  $i;
                $export['Disposal Type Name'] =  $data->disposaltype_name;
                $export['Created Date'] =  Displaydateformat($data->created_at);

                $exportData[] = $export;

                $i++;
            }

            $writer = SimpleExcelWriter::streamDownload('Disposal Type.xlsx')
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

            $allData = $this->disposaltype->exportdata();

            $header = [
                'No.',
                'Disposal Type Name',
                'Created Date',
            ];

            $data = array(
                'header' => $header,
                'content' => $allData,
                'pagetitle' => "Disposal Type Details",
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

            $view = view('wastemanagement.master.disposaltype.pdf', $data);
            $html = $view->render();



            $mpdf->WriteHTML($html);

            $filename = "Disposal Type.pdf";
            $mpdf->Output($filename, 'D');
        } catch (Exception $ex) {

            report($ex);
        }
    }
}
