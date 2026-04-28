<?php

namespace App\Http\Controllers\Chemical;

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
use App\Models\Chemical\ChemicalCategory;


class CategoryController extends Controller
{

    private $category;

    public function __construct()
    {

        $this->category = new ChemicalCategory();
    }

    public function index(Request $request)
    {

        if (Auth::check()) {
            if ($request->ajax()) {
                try {

                    $data =  $this->category->list();

                    $datatables = Datatables::of($data['data'])
                        ->addIndexColumn()
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

        return view('chemical.master.category.list', $data);
    }



    public function Delete(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $this->category->deleterecord($id);

            return response()->json(['status' => 'success', 'msg' => 'Chemical Category deleted successfully'], 200);
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
                'Category Name',
                'Created Date',
            ];

            $i = 1;
            foreach ($allData as $data) {

                $export = [];
                $export['No.'] =  $i;
                $export['Category Name'] =  $data->category_name;
                $export['Created Date'] =  Displaydateformat($data->created_at);

                $exportData[] = $export;

                $i++;
            }

            $writer = SimpleExcelWriter::streamDownload('Chemical Category.xlsx')
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
                'Category Name',
                'Created Date',
            ];

            $data = array(
                'header' => $header,
                'content' => $allData,
                'pagetitle' => "Chemical Category Details",
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

            $view = view('chemical.master.category.pdf', $data);
            $html = $view->render();



            $mpdf->WriteHTML($html);

            $filename = "Chemical Category.pdf";
            $mpdf->Output($filename, 'D');
        } catch (Exception $ex) {

            report($ex);
        }
    }
}
