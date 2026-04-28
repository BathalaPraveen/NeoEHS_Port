<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Exception;
use Illuminate\Support\Facades\Auth;
use Session;
use DB;
use Str;
use App\Models\User;
use App\Models\AdminCountry;
use App\Models\ATAR\UAUC;
use App\Models\Master\SliderImage;
use App\Models\Master\Announcement;
use App\Models\Master\Company;
use App\Models\Master\Department;
use App\Models\Master\Division;
use App\Models\Master\Location;
use App\Models\Master\SpecificLocation;

class AdminController extends Controller
{

    private $company;
    private $division;
    private $department;
    private $location;
    private $specificlocation;

    private $slider;
    private $announcement;

    private $uauc;

    public function __construct()
    {

        $this->company = new Company();
        $this->division = new Division();
        $this->department = new Department();
        $this->location = new Location();
        $this->specificlocation = new SpecificLocation();

        $this->slider = new SliderImage();
        $this->announcement = new Announcement();

        $this->uauc = new UAUC();
    }

    public function home()
    {

        $announcementlist = $this->announcement->limit(10)->get();
        $data = [
            'announcementlist' => $announcementlist,
        ];

        return view('admin.home', $data);
    }

    public function announcement()
    {

        $announcementlist = Announcement::paginate(10);


        return view('admin.announcement', compact('announcementlist'));
    }

    public function hsebulletin()
    {

        $sliderImage = $this->slider->getAll();
        $data = [
            'sliderImage' => $sliderImage,
        ];

        return view('admin.hsebulletin', $data);
    }

    public function settings()
    {

        $data = [];

        return view('admin.settings', $data);
    }

    public function index()
    {

        $user = Auth::user();

        $masterLink = [
            [
                'link' => 'location/list',
                'name' => 'Location',
                'count' => gettotalCount('location'),
                'icon' => 'bx bx-message-square-detail',
                'icon_color' => 'text-primary',
            ],
            [
                'link' => 'specificlocation/list',
                'name' => 'Specific Location',
                'count' => gettotalCount('specific_location'),
                'icon' => 'bx bx-message-square-detail',
                'icon_color' => 'text-primary',
            ],
            [
                'link' => 'company/list',
                'name' => 'Company',
                'count' => gettotalCount('company'),
                'icon' => 'bx bx-message-square-detail',
                'icon_color' => 'text-primary',
            ],

            [
                'link' => 'division/list',
                'name' => 'Division',
                'count' => gettotalCount('division'),
                'icon' => 'bx bx-message-square-detail',
                'icon_color' => 'text-primary',
            ],
            [
                'link' => 'department/list',
                'name' => 'Department',
                'count' => gettotalCount('department'),
                'icon' => 'bx bx-message-square-detail',
                'icon_color' => 'text-primary',
            ],
            [
                'link' => 'employee/list',
                'name' => 'Employee',
                'count' => gettotalCount('employee'),
                'icon' => 'bx bx-message-square-detail',
                'icon_color' => 'text-primary',
            ],
            [
                'link' => 'contractor/list',
                'name' => 'Contractor',
                'count' => gettotalCount('contractor'),
                'icon' => 'bx bx-message-square-detail',
                'icon_color' => 'text-primary',
            ],

        ];

        $rightcardDetails = [
            [
                'name' => 'Total UAUC',
                'count' => uaucStatusCount(),
                'icon' => 'bx bx-message-square-detail',
                'icon_color' => 'text-primary',
                'url' => admin_url('atar/uauc/list/'),
            ],
            [
                'name' => 'Total Pending',
                'count' => uaucStatusCount(1),
                'icon' => 'bx bx-file-find',
                'icon_color' => 'text-danger',
                'url' => admin_url('atar/uauc/list/' . encryptId(1)),

            ],
            [
                'name' => 'Total Accepted',
                'count' => uaucStatusCount(2),
                'icon' => 'bx bx-message-square-edit',
                'icon_color' => 'text-info  ',
                'url' => admin_url('atar/uauc/list/' . encryptId(2)),

            ],
            [
                'name' => 'Total Irrelevant',
                'count' => uaucStatusCount(4),
                'icon' => 'bx bx-x-circle',
                'icon_color' => 'text-danger',
                'url' => admin_url('atar/uauc/list/' . encryptId(4)),

            ],
            [
                'name' => 'Total Reassign',
                'count' => uaucStatusCount(3),
                'icon' => 'bx bx-transfer',
                'icon_color' => 'text-warning',
                'url' => admin_url('atar/uauc/list/' . encryptId(3)),

            ],
            [
                'name' => 'Total Closed',
                'count' => uaucStatusCount(5),
                'icon' => 'bx bx-message-square-check',
                'icon_color' => 'text-success',
                'url' => admin_url('atar/uauc/list/' . encryptId(5)),

            ],
        ];

        $sliderImage = $this->slider->getAll();

        $Chartdata =  UAUCChart();


        $PTWChartdata =  PTWChart();


        $ptw_card_data = [
            [
                'name' => 'General PTW',
                'id' => 'general',
                'chartdata' => ptwGeneralChartData(),
            ],
            [
                'name' => 'GAS Test Certificate',
                'id' => 'gastest',
                'chartdata' => ptwSubpermitChartData(PTW_SUB_PERMIT_GAS),
            ],
            [
                'name' => 'ISOLATION CERTIFICATE',
                'id' => 'isolation',
                'chartdata' => ptwSubpermitChartData(PTW_SUB_PERMIT_ISOLATION),
            ],
            [
                'name' => 'SURFACE PENETRATION CERTIFICATE',
                'id' => 'surfacepenetration',
                'chartdata' => ptwSubpermitChartData(PTW_SUB_PERMIT_SURFACE),
            ],
            [
                'name' => 'HOTWORK CERTIFICATE',
                'id' => 'hotwork',
                'chartdata' => ptwSubpermitChartData(PTW_SUB_PERMIT_HOTWORK),
            ],
            [
                'name' => 'WORKSITE TRAFFIC CERTIFICATE',
                'id' => 'worktraffic',
                'chartdata' => ptwSubpermitChartData(PTW_SUB_PERMIT_WORKTRAFFIC),
            ],
            [
                'name' => 'LIFTING PLAN',
                'id' => 'lifting',
                'chartdata' => ptwSubpermitChartData(PTW_SUB_PERMIT_LIFTING),
            ],
            [
                'name' => 'DIVING CERTIFICATE',
                'id' => 'diving',
                'chartdata' => ptwSubpermitChartData(PTW_SUB_PERMIT_DIVING),
            ],
        ];

        $locationDetails = $this->location->get();
        $specificlocationDetails = $this->specificlocation->get();

        $companyDetails = $this->company->get();
        $divisionDetails = $this->division->get();
        $departmentDetails = $this->department->get();


        $data = [

            'locationDetails' => $locationDetails,
            'specificlocationDetails' => $specificlocationDetails,
            'companyDetails' => $companyDetails,
            'divisionDetails' => $divisionDetails,
            'departmentDetails' => $departmentDetails,

            'masterLink' => $masterLink,
            'sliderImage' => $sliderImage,
            'rightcardDetails' => $rightcardDetails,
            'Chartdata' => $Chartdata,
            'PTWChartdata' => $PTWChartdata,
            'ptw_card_data' => $ptw_card_data,

        ];
        return view('admin.dashboardnew', $data);
    }

    public function profileView()
    {
        $id = Auth::user()->id;
        $page_data['user_detail'] = Auth::user();
        $page_data['country_detail'] = Auth::user();
        return view('admin.user_profile', $page_data);
    }

    public function profileUpdate(Request $request)
    {
        try {
            $id = Auth::id();

            $file = $request->file('profile_image');
            if ($file != null) {
                $uploadpath = 'public/uploads/profile';
                $filenewname = time() . Str::random('10') . '.' . $file->getClientOriginalExtension();
                $fileName = $file->getClientOriginalName();
                $fileSize = $file->getSize();
                $fileMimetype = $file->getMimeType();
                $fileExt = $file->getClientOriginalExtension();
                $file->move($uploadpath, $filenewname);
                $update_data['profile_image'] = $filenewname;

                User::where('id', $id)->update($update_data);
            }



            Session::flash('success', 'User profile is updated successfully!');
            return redirect(admin_url('profile'));
        } catch (Exception $ex) {

            return "Error";
        }
    }

    public function changeProfilePassword(Request $request)
    {

        try {

            $user = Auth::user();

            if (Auth::attempt(array('username' => Auth::user()->username, 'password' => $request->old_password))) {

                if ($request->password != null && $request->confirm_password != null) {
                    if ($request->password == $request->confirm_password) {
                        $password = $request->password;
                        $user->password = Hash::make($password);

                        $user->save();

                        Session::flash('success', 'Password updated successfully!');
                    } else {
                        Session::flash('error', 'Password Mismatch!');
                    }
                }
            } else {
                Session::flash('error', 'Invalid old password');
            }

            return redirect(admin_url('profile'));
        } catch (Exception $ex) {

            Session::flash('error', 'Please try after sometimes!');
            return redirect()->back();
        }
    }

    public function nopermission()
    {

        $data = [];

        return view('admin.nopermission', $data);
    }
}
