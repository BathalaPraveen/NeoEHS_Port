<?php

namespace App\Http\Controllers\Admin;

use Log;


use Exception;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\PasswordOTPEmail;
use Illuminate\Support\Carbon;
use App\Models\Master\Contractor;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;

use Illuminate\Support\Facades\Cookie;

use Illuminate\Support\Facades\Session;
use App\Models\Master\ContractorCompany;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Session\Session as SessionSession;

class LoginController extends Controller
{
    protected $partner;
    private $contractorcompany;
    private $contractor;


    public function __construct()
    {

        //$this->middleware('auth');
        $this->contractorcompany = new ContractorCompany();
        $this->contractor = new Contractor();
    }

    public function showLoginForm()
    {
        session(['link' => url()->previous()]);
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $rules = [
            'username' => 'required',
            'password' => 'required',
        ];
        $messages = [
            'username.required' => 'Please enter your email address!',
            'password.required' => 'Please enter your password',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('username', 'password');
        $remember = $request->has('remember') ? true : false;

        $additionalChecks = ['trash' => 'NO', 'status' => 1];

        if (Auth::attempt(array_merge($credentials, $additionalChecks), $remember)) {

            $request->session()->regenerate();
            Session::flash('success', 'Login successfully');
            return redirect()->intended(admin_url('home'));
        }
        Session::flash('error', 'Invalid Username and Password');
        return back()->withErrors([
            'username' => 'Username or Password is incorrect',
        ]);
    }

    public function redirectToMicrosoft()
    {
        return Socialite::driver('microsoft')->redirect();
    }

    public function handleMicrosoftCallback()
    {
        try {
            $microsoftUser = Socialite::driver('microsoft')->user();
            $email = $microsoftUser->getEmail();

            $user = User::where('email', $email)->first();

            if (!$user) {
                Session::flash('error', 'Invalid User');
                return redirect()->route('login')->withErrors([
                    'email' => 'Invalid User.',
                ]);
            }

            Auth::login($user);

            return redirect()->intended(admin_url('home'));
        } catch (Exception $e) {
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect()->route('login')->withErrors([
                'email' => 'Authentication failed. Please try again.',
            ]);
        }
    }


    public function logout(Request $request)
    {

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();


        return redirect(url('login'));
    }

    public function forgotPassword()
    {

        return view('auth.passwords.email');
    }
    public function contractorRegistration()
    {
        $malaysiaStates = DB::table('malaysia_states')->get();

        return view('auth.contractorRegister', compact('malaysiaStates'));
    }


    public function contractorRegistrationSubmit(Request $request)
    {

        $rules = [
            'con_comp_name' => 'required',
            'con_comp_roc' => 'required',
            'ssm_cerificate' => 'required',
            'type_of_business' => 'required',
            'address_1' => 'required',
            'postcode' => 'required',
            'city' => 'required',
            'state' => 'required',
            'con_comp_email' => 'required',
            'pic_name' => 'required',
            'pic_designation' => 'required',
            'pic_email' => 'required',

            'id_type' => 'required',
            'con_mc_or_passport_no' => 'required',
        ];
        $messages = [
            'con_comp_name.required' => 'Please enter the company name.',
            'con_comp_roc.required' => 'Please enter the ROC/ROB number.',
            'ssm_cerificate.required' => 'Please upload the SSM certificate.',
            'type_of_business.required' => 'Please select the type of business.',
            'address_1.required' => 'Please enter address line 1.',
            'postcode.required' => 'Please enter the postcode.',
            'city.required' => 'Please enter the city.',
            'state.required' => 'Please select the state.',
            'con_comp_email.required' => 'Please enter the company email address.',
            'pic_name.required' => 'Please enter the PIC name.',
            'pic_designation.required' => 'Please enter the PIC designation.',
            'pic_email.required' => 'Please enter the PIC email address.',
            'id_type.required' => 'Please select the ID type.',
            'con_mc_or_passport_no.required' => 'Please enter the MyKad or Passport number.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {

            $con_company_details =  $this->contractorcompany->Register();
            $userDetails = User::conReg();
            $contractorDetails = $this->contractor->register($userDetails->id, $con_company_details->id);

            Session::flash('success', 'Contractor Company Registerd successfully!');
            return redirect(admin_url('login'));
        } catch (Exception $ex) {
            dd($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect()->back();
        }
    }

    public function sendOTP(Request $request)
    {

        try {

            $rules = [
                'username' => 'required',
            ];
            $messages = [
                'username.required' => 'Please enter the username',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {

                return redirect()->back()->withErrors($validator)->withInput();
            }

            $user = User::where('username', '=', $request->username)->first();

            if ($user == null) {

                Session::flash('error', 'Invalid username');
                return redirect()->back();
            }

            if ($user->email == null || $user->email == '') {

                Session::flash('error', 'Please contact to the admin');
                return redirect()->back();
            }

            $username  = $user->username;

            $otp = mt_rand(100000, 999999);
            $email = $user->email;

            $expire_mins = env('OTP_EXPIRE', 10);

            Cache::forget('otp_' . $username);

            Cache::put('otp_' . $username, $otp, now()->addMinutes($expire_mins));

            $user->otp = $otp;
            $user->update();

            $empDetails = [
                'name' => $user->name,
                'username' => $username,
                'expire' => $expire_mins,
                'otp' => $otp
            ];

            Mail::to($user->email)->queue(new PasswordOTPEmail($empDetails));

            DB::table('password_resets')->where('email', $user->email)
                ->delete();

            DB::table('password_resets')->insert([
                'email' => $user->email,
                'token' => Str::random(60),
                'created_at' => Carbon::now()
            ]);

            $tokenData = DB::table('password_resets')
                ->where('email', $user->email)
                ->orderBy('created_at', 'Desc')
                ->first();

            $token = $tokenData->token;


            Session::flash('success', 'OTP sent to registered email Address');
            return redirect(admin_url('password/otp'))->with(['token' => $token]);
        } catch (Exception $ex) {

            Session::flash('error', 'Please try after sometime!');

            return redirect()->back();
        }
    }



    public function passwordOTP(Request $request)
    {

        $token = Session::get('token');

        if ($token == '' || $token == null) {

            Session::flash('error', 'Access Denied!');

            return redirect()->back();
        }

        $expire_mins = env('OTP_EXPIRE', 10);

        $newTime = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . " -" . $expire_mins . " minutes"));

        $tokenData = DB::table('password_resets')
            ->where('token', $token)
            ->where('created_at', '>=', $newTime)
            ->first();

        if ($tokenData == null) {
            Session::flash('error', 'Page Expired,Please try again');

            return redirect()->back();
        }



        $data = array(
            'token' => $token
        );

        return view('auth.passwords.otp', $data);
    }


    public function passwordOTPSubmit(Request $request)
    {

        $token = $request->token;


        $tokenData = DB::table('password_resets')
            ->where('token', $token)
            ->first();


        if ($tokenData == null) {
            Session::flash('error', 'Page Expired,Please try again');
            return redirect()->back();
        }

        $otp = $request->otp;
        $userCheck = User::where('email', $tokenData->email)->first();

        if ($otp != $userCheck->otp) {

            Session::flash('error', 'Invalid OTP');
            return redirect()->back()->with(['token' => $token]);
        }

        $username = $userCheck->username;

        if ($userCheck != null && $userCheck != '') {

            $cacheKey = 'otp_' . $username;

            if (!Cache::has($cacheKey)) {
                Session::flash('error', 'OTP expired');

                return redirect(admin_url('password/forgot'));
            }

            $token = encryptId($userCheck->id) . "_" . Str::random(16);

            $userCheck->otp_token = $token;
            $userCheck->update();

            DB::table('password_resets')
                ->where('email', $userCheck->email)
                ->delete();


            return redirect(admin_url('password/finalreset/form'))->with(['otp_token' =>  $token]);
        } else {

            Session::flash('error', 'OTP expired');

            return redirect(admin_url('password/forgot'));
        }
    }


    public function passwordReset(Request $request)
    {


        try {

            $token = Session::get('otp_token');

            if ($token == '' || $token == null) {

                Session::flash('error', 'Access Denied!');

                return redirect(admin_url('password/forgot'));
            }

            $expire_mins = env('OTP_EXPIRE', 10);
            $userCheck = User::where('otp_token', $token)->first();


            if ($userCheck == null) {
                Session::flash('error', 'Page Expired,Please try again');
                return redirect(admin_url('password/forgot'));
            }


            $data = array(
                'token' => $token
            );

            return view('auth.passwords.reset', $data);
        } catch (Exception $ex) {

            Session::flash('error', 'Please try after sometimes!');
            return redirect(admin_url('password/forgot'));
        }
    }

    public function passwordResetSubmit(Request $request)
    {

        try {

            $rules = [
                'token' => 'required',
                'password' => 'required',
                'confirmpassword' => 'required',
            ];

            $messages = [
                'token.required' => 'Username is required.',
                'password.required' => 'Token is required.',
                'confirmpassword.required' => 'Password is required.',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {

                return redirect()->back()->with(['otp_token' => $request->token]);
            }

            $token = $request->token;
            $password = $request->password;

            $userCheck = User::where('otp_token', $token)->first();



            if ($userCheck != null && $userCheck != '') {

                $userCheck->password = Hash::make($password);
                $userCheck->otp = null;
                $userCheck->otp_token = null;
                $userCheck->update();


                Session::flash('success', 'Successfully password reset');
                return redirect(admin_url('login'));
            } else {

                Session::flash('error', 'Please try after sometimes');
                return redirect(admin_url('login'));
            }
        } catch (Exception $ex) {

            Session::flash('error', 'Please try after sometimes!');
            return redirect()->back();
        }
    }
}
