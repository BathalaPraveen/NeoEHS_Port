<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Session;
use Exception;


use App\Models\Master\SliderImage;

class SliderController extends Controller
{

    private $slider;


    public function __construct()
    {

        $this->slider = new SliderImage();
    }


    public function index(Request $request)
    {

        $sliderImage = $this->slider->getAll();

        $data = array(
            'sliderImage' => $sliderImage
        );

        return view('master.slider.list', $data);
    }


    public function store(Request $request)
    {

        try {
            $this->slider->store();

            Session::flash('success', 'Slider image added successfully!');
            return redirect(admin_url('settings/slider'));

        } catch (Exception $ex) {

            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('settings/slider'));
        }
    }

    public function delete(Request $request)
    {

        $id = decryptId($request->id);

        try {

            $this->slider->remove($id);
            return response()->json(['status' => 'success', 'msg' => 'Slider image removed'], 200);
        } catch (Exception $ex) {

            return response()->json(['status' => 'error', 'msg' => 'Please try after some time'], 406);
        }
    }
}
