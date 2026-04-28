<?php

namespace App\Http\Controllers\ATAR;

use DateTime;
use App\Models\ATAR\UAUC;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UAUCChartController extends Controller
{
    private $uauc;


    public function __construct()
    {
        $this->uauc = new UAUC();
    }

    public function getUAUCCountChartData(Request $request)
    {
        $company = $request->input('company');
        $division = $request->input('division');
        $department = $request->input('department');
        $location = $request->input('location');
        $spec_location = $request->input('spec_location');
        $year = $request->input('year');
        $month = $request->input('month');

        $month = $request->input('month');
        $dateObj = DateTime::createFromFormat('M', $month);
        $month = $dateObj ? $dateObj->format('m') : null;

        $data = $this->uauc->getUAUCRecords($company, $division, $department, $location, $spec_location, $year, $month);

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function getUAUCCategoryChartData(Request $request)
    {
        $company = $request->input('company');
        $division = $request->input('division');
        $department = $request->input('department');
        $location = $request->input('location');
        $spec_location = $request->input('spec_location');
        $year = $request->input('year');
        $month = $request->input('month');

        $month = $request->input('month');
        $dateObj = DateTime::createFromFormat('M', $month);
        $month = $dateObj ? $dateObj->format('m') : null;


        $safe_act = $this->uauc->getUAUCCategory($company, $division, $department, $location, $spec_location, $year, $month, 1);
        $safe_condition = $this->uauc->getUAUCCategory($company, $division, $department, $location, $spec_location, $year, $month, 2);
        $unsafe_act = $this->uauc->getUAUCCategory($company, $division, $department, $location, $spec_location, $year, $month, 3);
        $unsafe_condition = $this->uauc->getUAUCCategory($company, $division, $department, $location, $spec_location, $year, $month, 4);

        return response()->json([
            'success' => true,
            'data' => [
                $safe_act,
                $safe_condition,
                $unsafe_act,
                $unsafe_condition,
            ]
        ]);
    }

    public function getHSCHazardChartData(Request $request)
    {
        $company = $request->input('company');
        $division = $request->input('division');
        $department = $request->input('department');
        $location = $request->input('location');
        $spec_location = $request->input('spec_location');
        $year = $request->input('year');
        $month = $request->input('month');

        $dateObj = DateTime::createFromFormat('M', $month);
        $month = $dateObj ? $dateObj->format('m') : null;

        $hse_hazard = $this->uauc->getHSCHazard($company, $division, $department, $location, $spec_location, $year, $month);

        $formattedData = [
            'labels' => [],
            'series' => []
        ];

        foreach ($hse_hazard as $hazardId => $count) {
            $hazardName = getHscHazardname($hazardId);
            $formattedData['labels'][] = $hazardName;
            $formattedData['series'][] = $count;
        }

        return response()->json([
            'success' => true,
            'data' => $formattedData
        ]);
    }

    public function getCorrectiveActionChartData(Request $request)
    {
        $company = $request->input('company');
        $division = $request->input('division');
        $department = $request->input('department');
        $location = $request->input('location');
        $spec_location = $request->input('spec_location');
        $year = $request->input('year');
        $month = $request->input('month');

        if ($month) {
            $dateObj = DateTime::createFromFormat('M', $month);
            $month = $dateObj ? $dateObj->format('m') : null;
        }

        $stop_work = $this->uauc->getCorrective($company, $division, $department, $location, $spec_location, $year, $month, 1);
        $immediate_action = $this->uauc->getCorrective($company, $division, $department, $location, $spec_location, $year, $month, 2);
        $ssds = $this->uauc->getCorrective($company, $division, $department, $location, $spec_location, $year, $month, 3);
        $recommendation = $this->uauc->getCorrective($company, $division, $department, $location, $spec_location, $year, $month, 4);

        return response()->json([
            'success' => true,
            'data' => [
                $stop_work,
                $immediate_action,
                $ssds,
                $recommendation,
            ]
        ]);
    }

    public function getZeFAChartData(Request $request)
    {
        $company = $request->input('company');
        $division = $request->input('division');
        $department = $request->input('department');
        $location = $request->input('location');
        $spec_location = $request->input('spec_location');
        $year = $request->input('year');
        $month = $request->input('month');
        
        $dateObj = DateTime::createFromFormat('M', $month);
        $month = $dateObj ? $dateObj->format('m') : null;
        
        $zefa = $this->uauc->getZeFAData($company, $division, $department, $location, $spec_location, $year, $month);

        $formattedData = [
            'labels' => [],
            'series' => []
        ];

        foreach ($zefa as $zefaId => $count) {
            $zefaName = ($zefaId);
            $formattedData['labels'][] = $zefaName;
            $formattedData['series'][] = $count;
        }

        return response()->json([
            'success' => true,
            'data' => $formattedData
        ]);
    }

    public function getInfringementData(Request $request)
    {
        $company = $request->input('company');
        $division = $request->input('division');
        $department = $request->input('department');
        $location = $request->input('location');
        $spec_location = $request->input('spec_location');
        $year = $request->input('year');
        $month = $request->input('month');

        $dateObj = DateTime::createFromFormat('M', $month);
        $month = $dateObj ? $dateObj->format('m') : null;

        $infringement = $this->uauc->getInfringementData($company, $division, $department, $location, $spec_location, $year, $month);

        $formattedData = [
            'labels' => [],
            'series' => []
        ];

        foreach ($infringement as $infringementId => $count) {
            $infringementName = getinfringementName($infringementId);
            $formattedData['labels'][] = $infringementName;
            $formattedData['series'][] = $count;
        }

        return response()->json([
            'success' => true,
            'data' => $formattedData
        ]);
    }
}
