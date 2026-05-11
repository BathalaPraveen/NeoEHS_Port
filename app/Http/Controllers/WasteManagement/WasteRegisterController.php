<?php

namespace App\Http\Controllers\WasteManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\SimpleExcel\SimpleExcelWriter;
use Illuminate\Support\Facades\Auth;

use PDF;
use Exception;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;


use App\Models\User;
use App\Models\WasteManagement\WasteType;
use App\Models\WasteManagement\WasteRegister;
use App\Models\WasteManagement\WasteCategory;
use App\Models\WasteManagement\WasteItem;

class WasteRegisterController extends Controller
{

    private $wastetype;
    private $wasteregister;
    private $wastecategory;
    private $wasteitem;

    public function __construct()
    {

        $this->wastetype = new WasteType();
        $this->wasteregister = new WasteRegister();
        $this->wastecategory = new WasteCategory();
        $this->wasteitem = new WasteItem();
    }

    public function index(Request $request)
    {

        if (Auth::check()) {
            if ($request->ajax()) {
                try {

                    $companyid = $request->company;
                    $data =  $this->wasteregister->list();

                    $datatables = Datatables::of($data['data'])
                        ->addIndexColumn()
                        ->addColumn('notificationdate', function ($row) {
                            $notificationdate = Displaydateformat($row->notification_date);
                            return $notificationdate;
                        })
                        ->addColumn('action', function ($row) use ($companyid) {
                            $btn = '';
                            $btn .= '<a href="' . admin_url('wastemanagement/' . $companyid . '/wasteregister/edit/' . encryptId($row->id)) . '" class="" title="Edit"><i class="fa-solid fa-pen-to-square"></i> ';
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
                    return response()->json(['status' => 'error', 'msg' => 'Please try after some time', $ex], 406);
                }
            }
        }

        $companyname = $request->company;
        $wastetypeList = $this->wastetype->get();
        $data = array(
            'companyname' => $companyname,
            'wastetypeList' => $wastetypeList,
        );

        return view('wastemanagement.wasteregister.list', $data);
    }


    public function Add(Request $request)
    {

        try {

            $companyname = $request->company;

            $wastetypeList = $this->wastetype->get();
            $wasteformList = $this->wasteitem->getWhere(WASTE_CATEGORY_WASTE_FORM);

            $data = array(
                'companyname' => $companyname,
                'wastetypeList' => $wastetypeList,
                'wasteformList' => $wasteformList,
            );

            return view('wastemanagement.wasteregister.add', $data);
        } catch (Exception $ex) {
            report($ex);
        }
    }

    public function Store(Request $request)
    {
        try {

            $rules = [
                'companyname' => 'required',
                'waste_code' => 'required',
                'waste_name' => 'required',
                'waste_form' => 'required',
                'notification_date' => 'required',
                'notification_no' => 'required',
            ];
            $messages = [
                'companyname.required' => 'Please ',
                'waste_code.required' => 'Please ',
                'waste_name.required' => 'Please ',
                'waste_form.required' => 'Please ',
                'notification_date.required' => 'Please ',
                'notification_no.required' => 'Please ',
            ];

            $companyid = $request->companyname;

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                Session::flash('error', 'Something went wrong, Please try after sometimes!');
                return redirect()->back()->withErrors($validator)->withInput();
            }



            $this->wasteregister->store();

            Session::flash('success', 'Waste Register added successfully!');
            return redirect(admin_url('wastemanagement/' . $companyid . '/wasteregister/list'));
        } catch (Exception $ex) {
            report($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('wastemanagement/' . $companyid . '/wasteregister/list'));
        }
    }



    public function Edit(Request $request)
    {
        try {

            $id = decryptId($request->id);

            $wasteregister = $this->wasteregister->selectOne($id);

            $companyname = $request->company;

            $wastetypeList = $this->wastetype->get();
            $wasteformList = $this->wasteitem->getWhere(WASTE_CATEGORY_WASTE_FORM);

            $data = array(
                'companyname' => $companyname,
                'wastetypeList' => $wastetypeList,
                'wasteformList' => $wasteformList,
                'wasteregister' => $wasteregister,
            );


            return view('wastemanagement.wasteregister.edit', $data);
        } catch (Exception $error) {
            report($error->getMessage());
        }
    }

    public function Update(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $rules = [
                'companyname' => 'required',
                'waste_code' => 'required',
                'waste_name' => 'required',
                'waste_form' => 'required',
                'notification_date' => 'required',
                'notification_no' => 'required',
            ];
            $messages = [
                'companyname.required' => 'Please ',
                'waste_code.required' => 'Please ',
                'waste_name.required' => 'Please ',
                'waste_form.required' => 'Please ',
                'notification_date.required' => 'Please ',
                'notification_no.required' => 'Please ',
            ];

            $companyid = $request->companyname;

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                Session::flash('error', 'Something went wrong, Please try after sometimes!');
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $this->wasteregister->updates($id);

            Session::flash('success', 'Waste Type updated successfully!');
            return redirect(admin_url('wastemanagement/' . $companyid . '/wasteregister/list'));
        } catch (Exception $ex) {
            report($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('wastemanagement/' . $companyid . '/wasteregister/list'));
        }
    }

    public function Delete(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $this->wasteregister->deleterecord($id);

            return response()->json(['status' => 'success', 'msg' => 'Waste Type deleted successfully'], 200);
        } catch (Exception $ex) {

            return response()->json(['status' => 'error', 'msg' => 'Please try after some time'], 406);
        }
    }



    public function ExportExcel(Request $request)
    {

        try {

            $allData = $this->wasteregister->exportdata();

            $header = [
                'No.',
                'Waste Code',
                'Waste Name',
                'Waste Form',
                'Notification Date',
                'Notification No',
                'Created by',
                'Created Date',
            ];

            $i = 1;
            foreach ($allData as $data) {

                $export = [];
                $export['No.'] =  $i;
                $export['Waste Code'] =  $data->wastetype_id;
                $export['Waste Name'] =  $data->wastetype_name;
                $export['Waste Form'] =  $data->item_name;
                $export['Notification Date'] =  $data->notification_date;
                $export['Notification No'] =  $data->notification_no;
                $export['Created by'] =  Displaydateformat($data->created_by);
                $export['Created Date'] =  Displaydateformat($data->created_at);


                $exportData[] = $export;

                $i++;
            }

            $writer = SimpleExcelWriter::streamDownload('Waste Register List.xlsx')
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

            $allData = $this->wasteregister->exportdata();
            //  dd( $allData);
            $header = [
                'No.',
                'Waste Code',
                'Waste Name',
                'Waste Form',
                'Notification Date',
                'Notification No',
                'Created by',
                'Created Date',
            ];

            $data = array(
                'header' => $header,
                'content' => $allData,
                'pagetitle' => "Waste Type Details",
            );
            // dd( $data );
            $property = [
                'tempDir' => 'public/pdf/temp/',
                'mode' => 'c',
                'margin_left' => 10,
                'margin_right' => 10,
                'margin_top' => 10,

            ];

            $mpdf = new \Mpdf\Mpdf($property);
            $mpdf->setAutoTopMargin = 'stretch';

            $view = view('wastemanagement.wasteregister.pdf', $data);
            $html = $view->render();



            $mpdf->WriteHTML($html);

            $filename = "Waste Type.pdf";
            $mpdf->Output($filename, 'D');
        } catch (Exception $ex) {

            report($ex);
        }
    }
}
