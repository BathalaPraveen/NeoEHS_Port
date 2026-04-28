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
use App\Models\WasteManagement\WasteRegister;
use App\Models\WasteManagement\WasteInventory;
use App\Models\WasteManagement\WasteInventoryDetails;
use App\Models\WasteManagement\WasteItem;
use App\Models\WasteManagement\DisposalType;



class WasteInventoryController extends Controller
{

    private $wastetype;
    private $wasteregister;
    private $wasteinventory;
    private $wasteinventorydetails;
    private $wasteitem;
    private $package;

    public function __construct()
    {

        $this->wastetype = new WasteType();
        $this->wasteregister = new WasteRegister();
        $this->wasteinventory = new WasteInventory();
        $this->wasteinventorydetails = new WasteInventoryDetails();
        $this->wasteitem = new WasteItem();
        $this->package = new DisposalType();
    }

    public function index(Request $request)
    {

        if (Auth::check()) {
            if ($request->ajax()) {
                try {

                    $companyid = $request->company;

                    $data =  $this->wasteinventory->list();

                    $datatables = Datatables::of($data['data'])
                        ->addIndexColumn()
                        ->addColumn('generation_date', function ($row) {
                            $notificationdate = Displaydateformat($row->generation_date);
                            return $notificationdate;
                        })
                        ->addColumn('location_name', function ($row) {
                            $notificationdate = getItemName($row->location);
                            return $notificationdate;
                        })
                        ->addColumn('package_name', function ($row) {
                            $notificationdate = getpackageName($row->type_of_packing);
                            return $notificationdate;
                        })

                        ->addColumn('action', function ($row) use ($companyid) {
                            $btn = '';
                            // $btn .= '<a href="' . admin_url('wastemanagement/' . $companyid . '/wasteregister/edit/' . encryptId($row->id)) . '" class="" title="Edit"><i class="fa-solid fa-pen-to-square"></i> ';
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

        $companyname = $request->company;

        $wastetypedetails = $this->wastetype->get();

        $data = array(
            'companyname' => $companyname,
            'wastetypedetails' => $wastetypedetails,
        );
        return view('wastemanagement.wasteinventory.list', $data);
    }


    public function addindex(Request $request)
    {

        if (Auth::check()) {
            if ($request->ajax()) {
                try {

                    $companyid = $request->company;

                    $data =  $this->wasteinventorydetails->addlist();

                    $datatables = Datatables::of($data['data'])
                        ->addIndexColumn()
                        ->addColumn('generation_date', function ($row) {
                            $notificationdate = Displaydateformat($row->generation_date);
                            return $notificationdate;
                        })
                        ->addColumn('location_name', function ($row) {
                            $notificationdate = getItemName($row->location);
                            return $notificationdate;
                        })
                        ->addColumn('package_name', function ($row) {
                            $notificationdate = getpackageName($row->type_of_packing);
                            return $notificationdate;
                        })

                        ->addColumn('action', function ($row) use ($companyid) {
                            $btn = '';
                            // $btn .= '<a href="' . admin_url('wastemanagement/' . $companyid . '/wasteregister/edit/' . encryptId($row->id)) . '" class="" title="Edit"><i class="fa-solid fa-pen-to-square"></i> ';
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

        $companyname = $request->company;

        $wastetypedetails = $this->wastetype->get();

        $data = array(
            'companyname' => $companyname,
            'wastetypedetails' => $wastetypedetails,
        );
        return view('wastemanagement.wasteinventory.addlist', $data);
    }

    public function Add(Request $request)
    {

        try {

            $companyname = $request->company;

            $wastetypeList = $this->wastetype->get();
            $packageList = $this->package->get();
            $wastelocationList = $this->wasteitem->getWhere(WASTE_CATEGORY_WASTE_LOCATION);

            $data = array(
                'companyname' => $companyname,
                'wastetypeList' => $wastetypeList,
                'wastelocationList' => $wastelocationList,
                'packageList' => $packageList,
            );
            return view('wastemanagement.wasteinventory.add', $data);
        } catch (Exception $ex) {
            report($ex);
        }
    }

    public function Store(Request $request)
    {
        try {

            $rules = [
                'companyname' => 'required',
            ];

            $messages = [
                'companyname.required' => 'Please enter Waste Type ID',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                Session::flash('error', 'Something went wrong, Please try after sometimes!');
                return redirect()->back()->withErrors($validator)->withInput();
            }

            try {

                $companyId =  getCompanyId($request->companyname);
                $companyname = $request->companyname;

                $this->wasteinventorydetails->store();
                $this->wasteinventory->additems();

                Session::flash('success', 'Waste Inventory added successfully!');
            } catch (Exception $ex) {
                Session::flash('error', 'Something went wrong, Please try after sometimes!');
            }

            return redirect(admin_url('wastemanagement/' . $companyname . '/wasteinventory/list'));
        } catch (Exception $ex) {

            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('wastemanagement/' . $companyname . '/wasteinventory/list'));
        }
    }

    public function disposalindex(Request $request)
    {

        if (Auth::check()) {
            if ($request->ajax()) {
                try {

                    $companyid = $request->company;
                    $data =  $this->wasteinventorydetails->disposallist();

                    $datatables = Datatables::of($data['data'])
                        ->addIndexColumn()
                        ->addColumn('generation_date', function ($row) {
                            $notificationdate = Displaydateformat($row->generation_date);
                            return $notificationdate;
                        })
                        ->addColumn('entry_date', function ($row) {
                            $entrydate = Displaydateformat($row->entry_date);
                            return $entrydate;
                        })
                        ->addColumn('location_name', function ($row) {
                            $notificationdate = getItemName($row->location);
                            return $notificationdate;
                        })
                        ->addColumn('package_name', function ($row) {
                            $notificationdate = getpackageName($row->type_of_packing);
                            return $notificationdate;
                        })

                        ->addColumn('action', function ($row) use ($companyid) {
                            $btn = '';
                            // $btn .= '<a href="' . admin_url('wastemanagement/' . $companyid . '/wasteregister/edit/' . encryptId($row->id)) . '" class="" title="Edit"><i class="fa-solid fa-pen-to-square"></i> ';
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

        $companyname = $request->company;

        $wastetypedetails = $this->wastetype->get();

        $data = array(
            'companyname' => $companyname,
            'wastetypedetails' => $wastetypedetails,
        );

        return view('wastemanagement.wasteinventory.disposallist', $data);
    }
    public function Disposal(Request $request)
    {

        try {

            $companyname = $request->company;
            $companyId = getCompanyId($companyname);

            $getwhere = array(
                'company_id' => $companyId,
            );

            $inventorylist = $this->wasteinventory->getDetails($getwhere);

            $wastetypeList = $this->wastetype->get();
            $packageList = $this->package->get();
            $wastelocationList = $this->wasteitem->getWhere(WASTE_CATEGORY_WASTE_LOCATION);

            $data = array(
                'inventorylist' => $inventorylist,
                'companyname' => $companyname,
                'wastetypeList' => $wastetypeList,
                'wastelocationList' => $wastelocationList,
                'packageList' => $packageList,
            );
            return view('wastemanagement.wasteinventory.disposal', $data);
        } catch (Exception $ex) {

            report($ex);
        }
    }

    public function DisposalStore(Request $request)
    {
        try {

            $rules = [
                'companyname' => 'required',
            ];
            $messages = [
                'companyname.required' => 'Please enter Waste Type ID',

            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                Session::flash('error', 'Something went wrong, Please try after sometimes!');
                return redirect()->back()->withErrors($validator)->withInput();
            }

            try {

                $companyId =  getCompanyId($request->companyname);
                $companyname = $request->companyname;

                $this->wasteinventorydetails->disposalstore();
                $this->wasteinventory->removeitems();


                Session::flash('success', 'Waste Inventory added successfully!');
            } catch (Exception $ex) {

                Session::flash('error', 'Something went wrong, Please try after sometimes!');
            }

            return redirect(admin_url('wastemanagement/' . $companyname . '/wasteinventory/list'));
        } catch (Exception $ex) {



            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('wastemanagement/' . $companyname . '/wasteinventory/list'));
        }
    }

    public function Edit(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $wastetype = $this->wasteinventory->selectOne($id);
            $data = array(
                'wastetype' => $wastetype,
            );

            return view('wastemanagement.wasteinventory.edit', $data);
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

            $this->wasteinventory->updates($id);

            Session::flash('success', 'Waste Type updated successfully!');
            return redirect(admin_url('wastemanagement/master/wasteregister/list'));
        } catch (Exception $ex) {

            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('wastemanagement/master/wasteregister/list'));
        }
    }
    public function Delete(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $this->wasteinventory->deleterecord($id);

            return response()->json(['status' => 'success', 'msg' => 'Waste Inventory Item successfully deleted'], 200);
        } catch (Exception $ex) {

            return response()->json(['status' => 'error', 'msg' => 'Please try after some time'], 406);
        }
    }


    public function ExportExcel(Request $request)
    {

        try {

            $allData = $this->wasteinventory->exportdata();

            $header = [
                'No.',
                'Waste Name',
                'Waste Code',
                'Generation Date',
                'Location',
                'Quantity',
                'Type of Packing',
                'Estimated Weight (MT)',
                'Created by',
                'Created Date',
            ];

            $i = 1;
            foreach ($allData as $data) {

                $export = [];
                $export['No.'] =  $i;
                $export['Waste Name'] =  $data->wastetype_name;
                $export['Waste Code'] =  $data->wastetype_id;
                $export['Generation Date'] =  $data->generation_date;
                $export['Location'] =  $data->item_name;
                $export['Quantity'] =  $data->quantity;
                $export['Type of Packing'] =  $data->disposaltype_name;
                $export['Estimated Weight (MT)'] =  $data->estimated_weight;
                $export['Created by'] =  getusername($data->created_by);
                $export['Created Date'] =  Displaydateformat($data->created_at);

                $exportData[] = $export;

                $i++;
            }

            $writer = SimpleExcelWriter::streamDownload('Waste Inventory List .xlsx')
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

            $allData = $this->wasteinventory->exportdata();

            $header = [
                'No.',
                'Waste Name',
                'Waste Code',
                'Generation Date',
                'Location',
                'Quantity',
                'Type of Packing',
                'Estimated Weight
                (MT)',
                'Created by',
                'Created Date',
            ];

            $data = array(
                'header' => $header,
                'content' => $allData,
                'pagetitle' => "Waste Inventory List",
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

            $view = view('wastemanagement.wasteinventory.pdf', $data);
            $html = $view->render();



            $mpdf->WriteHTML($html);

            $filename = "Waste Inventory List.pdf";
            $mpdf->Output($filename, 'D');
        } catch (Exception $ex) {

            report($ex);
        }
    }

    public function ExportExcelAdd(Request $request)
    {

        try {

            $allData = $this->wasteinventorydetails->exportdataadd();

            $header = [
                'No.',
                'Waste Name',
                'Waste Code',
                'Generation Date',
                'Location',
                'Quantity',
                'Type of Packing',
                'Estimated Weight',
                'Created By',
                'Created Date',
            ];

            $i = 1;
            foreach ($allData as $data) {

                $export = [];
                $export['No.'] =  $i;
                $export['Waste Name'] =  $data->wastetype_name;
                $export['Waste Code'] =  $data->wastetype_id;
                $export['Generation Date'] =  Displaydateformat($data->generation_date);
                $export['Location'] =  getItemName($data->location);
                $export['Quantity'] =  $data->quantity;
                $export['Type of Packing'] =  getpackageName($data->type_of_packing);
                $export['Estimated Weight'] =  $data->estimated_weight;
                $export['Created By'] =  getusername($data->created_by);
                $export['Created Date'] =  Displaydateformat($data->created_at);

                $exportData[] = $export;

                $i++;
            }

            $writer = SimpleExcelWriter::streamDownload('Waste Inventory Add details.xlsx')
                ->addHeader($header)
                ->addRows(
                    $exportData
                );
        } catch (Exception $ex) {

            report($ex);
        }
    }

    public function ExportPdfAdd(Request $request)
    {

        try {

            $allData = $this->wasteinventorydetails->exportdataadd();

            $header = [
                'No.',
                'Waste Name',
                'Waste Code',
                'Generation Date',
                'Location',
                'Quantity',
                'Type of Packing',
                'Estimated Weight',
                'Created By',
                'Created Date',
            ];

            $data = array(
                'header' => $header,
                'content' => $allData,
                'pagetitle' => "Waste Inventory Add Details",
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

            $view = view('wastemanagement.wasteinventory.pdfadd', $data);
            $html = $view->render();



            $mpdf->WriteHTML($html);

            $filename = "Waste Inventory Add Details.pdf";
            $mpdf->Output($filename, 'D');
        } catch (Exception $ex) {

            report($ex);
        }
    }

    public function ExportExcelDisposal(Request $request)
    {

        try {

            $allData = $this->wasteinventorydetails->exportdatadisposal();

            $header = [
                'No.',
                'Waste Name',
                'Waste Code',
                'Generation Date',
                'Location',
                'Quantity',
                'Type of Packing',
                'Estimated Weight',
                'Disposal Date',
                'Disposal Quantity',
                'Balance',
                'Created By',
                'Created Date',
            ];

            $i = 1;
            foreach ($allData as $data) {

                $export = [];
                $export['No.'] =  $i;
                $export['Waste Name'] =  $data->wastetype_name;
                $export['Waste Code'] =  $data->wastetype_id;
                $export['Generation Date'] =  Displaydateformat($data->generation_date);
                $export['Location'] =  getItemName($data->location);
                $export['Quantity'] =  $data->quantity;
                $export['Type of Packing'] =  getpackageName($data->type_of_packing);
                $export['Estimated Weight'] =  $data->estimated_weight;
                $export['Disposal Date'] =  Displaydateformat($data->entry_date);
                $export['Disposal Quantity'] =  $data->entry_qty;
                $export['Balance'] =  $data->current_qty;
                $export['Created By'] =  getusername($data->created_by);
                $export['Created Date'] =  Displaydateformat($data->created_at);

                $exportData[] = $export;

                $i++;
            }

            $writer = SimpleExcelWriter::streamDownload('Waste Inventory Disposal details.xlsx')
                ->addHeader($header)
                ->addRows(
                    $exportData
                );
        } catch (Exception $ex) {

            report($ex);
        }
    }

    public function ExportPdfDisposal(Request $request)
    {

        try {

            $allData = $this->wasteinventorydetails->exportdatadisposal();

            $header = [
                'No.',
                'Waste Name',
                'Waste Code',
                'Generation Date',
                'Location',
                'Quantity',
                'Type of Packing',
                'Estimated Weight',
                'Disposal Date',
                'Disposal Quantity',
                'Balance',
                'Created By',
                'Created Date',
            ];

            $data = array(
                'header' => $header,
                'content' => $allData,
                'pagetitle' => "Waste Inventory Disposal Details",
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

            $view = view('wastemanagement.wasteinventory.pdfdisposal', $data);
            $html = $view->render();



            $mpdf->WriteHTML($html);

            $filename = "Waste Inventory Disposal Details.pdf";
            $mpdf->Output($filename, 'D');
        } catch (Exception $ex) {

            report($ex);
        }
    }
}
