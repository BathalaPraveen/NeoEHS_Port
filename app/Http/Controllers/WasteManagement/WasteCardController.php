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
use App\Models\WasteManagement\WasteCompany;
use App\Models\WasteManagement\WasteCard;
use App\Models\WasteManagement\WasteItem;
use App\Models\WasteManagement\DisposalType;



class WasteCardController extends Controller
{

    private $wastetype;
    private $wasteregister;
    private $wastecard;
    private $wastecompany;
    private $wasteitem;
    private $packagetype;

    public function __construct()
    {

        $this->wastetype = new WasteType();
        $this->wasteregister = new WasteRegister();
        $this->wastecard = new WasteCard();
        $this->wastecompany = new wastecompany();
        $this->wasteitem = new WasteItem();
        $this->packagetype = new DisposalType();
    }

    public function index(Request $request)
    {

        if (Auth::check()) {
            if ($request->ajax()) {
                try {

                    $data =  $this->wastecard->list();

                    $companyid = $request->company;

                    $datatables = Datatables::of($data['data'])
                        ->addIndexColumn()
                        ->addColumn('updated_date', function ($row) {
                            $notificationdate = Displaydateformat($row->updated_at);
                            return $notificationdate;
                        })
                        ->addColumn('action', function ($row) use ($companyid) {
                            $btn = '';
                            $btn .= '<a href="' . admin_url('wastemanagement/' . $companyid . '/wastecard/view/' . encryptId($row->id)) . '" class="" title="View"><i class="fa-solid fa-eye"></i> ';
                            $btn .= '<a href="' . admin_url('wastemanagement/' . $companyid . '/wastecard/edit/' . encryptId($row->id)) . '" class="" title="Edit"><i class="fa-solid fa-pen-to-square"></i> ';
                            $btn .= '<a href="javascript:void(0);"  data-id="' . encryptId($row->id) . '"  class="recordDelete" title="Delete"><i class="fa-solid fa-trash text-danger" ></i></i></a> ';
                            $btn .= '<a href="' . admin_url('wastemanagement/' . $companyid . '/wastecard/export/pdf/' . encryptId($row->id)).'" class=" " title="Pdf"><i class="fa fa-file-pdf-o"></i> ';
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

        $data = array(
            'companyname' => $companyname
        );

        return view('wastemanagement.wastecard.list', $data);
    }


    public function Add(Request $request)
    {

        try {

            $companyname = $request->company;

            $wastetypeList = $this->wastetype->get();
            $wastecompanyList = $this->wastecompany->selectOne();
            $wasteroomtemplist = $this->wasteitem->getWhere(WASTE_CATEGORY_FORM_IN_ROOM_TEMP);
            $wastesolubilitylist = $this->wasteitem->getWhere(WASTE_CATEGORY_SOLUBILITY_IN_WATER);
            $wastedensitylist = $this->wasteitem->getWhere(WASTE_CATEGORY_DENSITY);
            $wasterisklist = $this->wasteitem->getWhere(WASTE_CATEGORY_RISKS);
            $wasteppelist = $this->wasteitem->getWhere(WASTE_CATEGORY_PPE);

            $wastepackageList = $this->packagetype->get();

            $wastedisposallist = $this->wasteitem->getWhere(WASTE_CATEGORY_METHOD_OF_DISPOSAL);

            $data = array(
                'companyname' => $companyname,
                'wastecompanyList' => $wastecompanyList,
                'wastetypeList' => $wastetypeList,
                'wasteroomtemplist' => $wasteroomtemplist,
                'wastesolubilitylist' => $wastesolubilitylist,
                'wastedensitylist' => $wastedensitylist,
                'wasterisklist' => $wasterisklist,
                'wasteppelist' => $wasteppelist,
                'wastepackageList' => $wastepackageList,
                'wastedisposallist' => $wastedisposallist,
            );

            return view('wastemanagement.wastecard.add', $data);
        } catch (Exception $ex) {
            report($ex);
        }
    }

    public function Store(Request $request)
    {

        try {

            $companyid = $request->companyname;

            $rules = [
                'companyname' => 'required',
                'company' => 'required',
            ];
            $messages = [
                'companyname.required' => 'Please enter Waste Type ID',
                'company.required' => 'Please enter Waste Type Name',


            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                Session::flash('error', 'Something went wrong, Please try after sometimes!');
                return redirect()->back()->withErrors($validator)->withInput();
            }

            try {

                $this->wastecard->store();

                Session::flash('success', 'Waste Card added successfully!');
            } catch (Exception $ex) {

                Session::flash('error', 'Something went wrong, Please try after sometimes!');
            }

            return redirect(admin_url('wastemanagement/' . $companyid . '/wastecard/list'));
        } catch (Exception $ex) {

            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('wastemanagement/' . $companyid . '/wastecard/list'));
        }
    }

    public function View(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $companyname = $request->company;

            $wastecard = $this->wastecard->selectOne($id);
            $companydetails = $this->wastecompany->find($wastecard->company);
            $wastetypedetails = $this->wastetype->find($wastecard->waste_code);

            $wastetypeList = $this->wastetype->get();
            $wastecompanyList = $this->wastecompany->get();
            $wasteroomtemplist = $this->wasteitem->getWhere(WASTE_CATEGORY_FORM_IN_ROOM_TEMP);
            $wastesolubilitylist = $this->wasteitem->getWhere(WASTE_CATEGORY_SOLUBILITY_IN_WATER);
            $wastedensitylist = $this->wasteitem->getWhere(WASTE_CATEGORY_DENSITY);
            $wasterisklist = $this->wasteitem->getWhere(WASTE_CATEGORY_RISKS);
            $wasteppelist = $this->wasteitem->getWhere(WASTE_CATEGORY_PPE);

            $wastepackageList = $this->packagetype->get();

            $wastedisposallist = $this->wasteitem->getWhere(WASTE_CATEGORY_METHOD_OF_DISPOSAL);

            $data = array(
                'companyname' => $companyname,
                'wastecard' => $wastecard,
                'companydetails' => $companydetails,
                'wastetypedetails' => $wastetypedetails,
                'wastecompanyList' => $wastecompanyList,
                'wastetypeList' => $wastetypeList,
                'wasteroomtemplist' => $wasteroomtemplist,
                'wastesolubilitylist' => $wastesolubilitylist,
                'wastedensitylist' => $wastedensitylist,
                'wasterisklist' => $wasterisklist,
                'wasteppelist' => $wasteppelist,
                'wastepackageList' => $wastepackageList,
                'wastedisposallist' => $wastedisposallist,
            );

            return view('wastemanagement.wastecard.view', $data);
        } catch (Exception $error) {
            report($error->getMessage());
        }
    }


    public function Edit(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $companyname = $request->company;
            $wastecard = $this->wastecard->selectOne($id);

            $companydetails = $this->wastecompany->find($wastecard->company);
            $wastetypedetails = $this->wastetype->find($wastecard->waste_code);

            $wastetypeList = $this->wastetype->get();
            $wastecompanyList = $this->wastecompany->get();
            $wasteroomtemplist = $this->wasteitem->getWhere(WASTE_CATEGORY_FORM_IN_ROOM_TEMP);
            $wastesolubilitylist = $this->wasteitem->getWhere(WASTE_CATEGORY_SOLUBILITY_IN_WATER);
            $wastedensitylist = $this->wasteitem->getWhere(WASTE_CATEGORY_DENSITY);
            $wasterisklist = $this->wasteitem->getWhere(WASTE_CATEGORY_RISKS);
            $wasteppelist = $this->wasteitem->getWhere(WASTE_CATEGORY_PPE);

            $wastepackageList = $this->packagetype->get();

            $wastedisposallist = $this->wasteitem->getWhere(WASTE_CATEGORY_METHOD_OF_DISPOSAL);


            $data = array(
                'companyname' => $companyname,
                'wastecard' => $wastecard,
                'companydetails' => $companydetails,
                'wastetypedetails' => $wastetypedetails,

                'wastecompanyList' => $wastecompanyList,
                'wastetypeList' => $wastetypeList,
                'wasteroomtemplist' => $wasteroomtemplist,
                'wastesolubilitylist' => $wastesolubilitylist,
                'wastedensitylist' => $wastedensitylist,
                'wasterisklist' => $wasterisklist,
                'wasteppelist' => $wasteppelist,
                'wastepackageList' => $wastepackageList,
                'wastedisposallist' => $wastedisposallist,
            );



            return view('wastemanagement.wastecard.edit', $data);
        } catch (Exception $error) {
            report($error->getMessage());
        }
    }

    public function Update(Request $request)
    {
        try {

            $companyid = $request->companyname;
            $id = decryptId($request->id);

            $rules = [
                'companyname' => 'required',
                'company' => 'required',
            ];
            $messages = [
                'companyname.required' => 'Please enter Waste Type ID',
                'company.required' => 'Please enter Waste Type Name',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                Session::flash('error', 'Something went wrong, Please try after sometimes!');
                return redirect()->back()->withErrors($validator)->withInput();
            }

            try {
                $this->wastecard->updates($id);

                Session::flash('success', 'Waste Card update successfully!');
            } catch (Exception $ex) {

                Session::flash('error', 'Something went wrong, Please try after sometimes!');
            }

            return redirect(admin_url('wastemanagement/' . $companyid . '/wastecard/list'));
        } catch (Exception $ex) {

            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('wastemanagement/' . $companyid . '/wastecard/list'));
        }
    }

    public function Delete(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $this->wastecard->deleterecord($id);

            return response()->json(['status' => 'success', 'msg' => 'Waste Card deleted successfully'], 200);
        } catch (Exception $ex) {

            return response()->json(['status' => 'error', 'msg' => 'Please try after some time'], 406);
        }
    }



    public function ExportExcel(Request $request)
    {

        try {

            $allData = $this->wastecard->exportdata();

            $header = [
                'No.',
                'Waste Name',
                'Waste Code',
                'Created By',
                'Created Date',
            ];

            $i = 1;
            foreach ($allData as $data) {

                $export = [];
                $export['No.'] =  $i;
                $export['Waste Name'] =  $data->wastetype_name;
                $export['Waste Code'] =  $data->wastetype_id;
                $export['Created By'] =  getusername($data->created_by);
                $export['Created Date'] =  Displaydateformat($data->created_at);

                $exportData[] = $export;

                $i++;
            }

            $writer = SimpleExcelWriter::streamDownload('Waste Card Details.xlsx')
                ->addHeader($header)
                ->addRows(
                    $exportData
                );
        } catch (Exception $ex) {

            report($ex);
        }
    }

    public function ExportViewPdf(Request $request)
    {

        try {
            $id = decryptId($request->id);

            $companyname = $request->company;

            $wastecard = $this->wastecard->selectOne($id);
            $companydetails = $this->wastecompany->find($wastecard->company);
            $wastetypedetails = $this->wastetype->find($wastecard->waste_code);

            $wastetypeList = $this->wastetype->get();
            $wastecompanyList = $this->wastecompany->get();
            $wasteroomtemplist = $this->wasteitem->getWhere(WASTE_CATEGORY_FORM_IN_ROOM_TEMP);
            $wastesolubilitylist = $this->wasteitem->getWhere(WASTE_CATEGORY_SOLUBILITY_IN_WATER);
            $wastedensitylist = $this->wasteitem->getWhere(WASTE_CATEGORY_DENSITY);
            $wasterisklist = $this->wasteitem->getWhere(WASTE_CATEGORY_RISKS);
            $wasteppelist = $this->wasteitem->getWhere(WASTE_CATEGORY_PPE);

            $wastepackageList = $this->packagetype->get();

            $wastedisposallist = $this->wasteitem->getWhere(WASTE_CATEGORY_METHOD_OF_DISPOSAL);

            $pagetitle = "Waste Card Details";

           $data = array(
                'companyname' => $companyname,
                'wastecard' => $wastecard,
                'companydetails' => $companydetails,
                'wastetypedetails' => $wastetypedetails,


                'wastecompanyList' => $wastecompanyList,
                'wastetypeList' => $wastetypeList,
                'wasteroomtemplist' => $wasteroomtemplist,
                'wastesolubilitylist' => $wastesolubilitylist,
                'wastedensitylist' => $wastedensitylist,
                'wasterisklist' => $wasterisklist,
                'wasteppelist' => $wasteppelist,
                'wastepackageList' => $wastepackageList,
                'wastedisposallist' => $wastedisposallist,
                'pagetitle' => $pagetitle,

            );

            $property = [
                'tempDir' => 'public/pdf/temp/',
                'mode' => 'c',
                'margin_left' => 10,
                'margin_right' => 10,
                'margin_top' => 10,
                'use_k' => true,

            ];

            $mpdf = new \Mpdf\Mpdf($property);
            $mpdf->setAutoTopMargin = 'stretch';

            $view = view('wastemanagement.wastecard.pdf.wastecard', $data);
            $html = $view->render();

            $mpdf->WriteHTML($html);

            $filename = "Waste Card Details.pdf";
            $mpdf->Output($filename, 'D');
        } catch (Exception $ex) {

            report($ex);
        }
    }


    public function ExportPdf(Request $request)
    {

        try {

            $allData = $this->wastecard->exportdata();

            $header = [
                'No.',
                'Waste Name',
                'Waste  Code',
                'Created By',
                'Created Date',
            ];

            $data = array(
                'header' => $header,
                'content' => $allData,
                'pagetitle' => "Waste Card Details",
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

            $view = view('wastemanagement.wastecard.pdf', $data);
            $html = $view->render();



            $mpdf->WriteHTML($html);

            $filename = "Waste Card Details.pdf";
            $mpdf->Output($filename, 'D');
        } catch (Exception $ex) {

            report($ex);
        }
    }
}
