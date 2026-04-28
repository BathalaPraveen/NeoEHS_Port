<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;



class LoginController extends BaseController
{
    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request): JsonResponse
    {

        $rules = [
            'username' => 'required',
            'password' => 'required',
            'fcm_token' => 'required',
        ];

        $messages = [
            'username.required' => 'Username is required.',
            'password.required' => 'Password is required.',
            'fcm_token.required' => 'FCM Token is required.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return $this->sendError('Validation Error', $validator->errors(), 422);
        }

        $credentials = ['username' => $request->username, 'password' => $request->password];
        $additionalChecks = ['trash' => 'NO', 'status' => 1];

        if (Auth::attempt(array_merge($credentials, $additionalChecks))) {
            $user = Auth::user();
            $success['token'] =  $user->createToken('Bintulu')->accessToken;
            $success['name'] =  $user->name;

            $token = $request->fcm_token;

            if($request->has('device_type')){
                $device_type = $request->device_type ;
            }else{
                $device_type = 'android' ;
            }

            $user->fcmTokens()->create(['token' => $token, 'device_type' => $device_type]);

            return $this->sendResponse($success, 'User login successfully.');
        } else {
            return $this->sendError('Invalid user details', ['error' => 'Unauthorised'], 406);
        }
    }

    public function forgotPassword(Request $request): JsonResponse
    {

        $rules = [
            'username' => 'required',
        ];

        $messages = [
            'username.required' => 'Username is required.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return $this->sendError('Validation Error', $validator->errors(), 422);
        }

        $username = $request->username;
        $userCheck = User::where('username', $username)->first();

        if ($userCheck != null && $userCheck != '') {

            if ($userCheck->email == null || $userCheck->email == '') {
                return $this->sendError('Email id not found, please contact Admin', ['error' => 'Unauthorised'], 406);
            }

            $otp = mt_rand(100000, 999999);
            $email = $userCheck->email;

            $expire_mins = env('OTP_EXPIRE', 10);

            Cache::put('otp_' . $username, $otp, now()->addMinutes($expire_mins));

            $userCheck->otp = $otp;
            $userCheck->update();

            $success = [
                'expire' => $expire_mins,
                'otp' => $otp
            ];

            return $this->sendResponse($success, 'OTP Sent to registered email');
        } else {
            return $this->sendError('Invalid Username', ['error' => 'Unauthorised'], 406);
        }
    }

    public function passwordOtp(Request $request): JsonResponse
    {

        $rules = [
            'username' => 'required',
            'otp' => 'required',
        ];

        $messages = [
            'username.required' => 'Username is required.',
            'otp.required' => 'OTP is required.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return $this->sendError('Validation Error', $validator->errors(), 422);
        }


        $username = $request->username;
        $otp = $request->otp;
        $userCheck = User::where('username', $username)->where('otp', $otp)->first();

        if ($userCheck != null && $userCheck != '') {

            $cacheKey = 'otp_' . $username;

            if (!Cache::has($cacheKey)) {

                return $this->sendError('OTP Expired', ['error' => 'Unauthorised'], 406);
            }

            $token = Str::random(16);

            $userCheck->otp_token = $token;
            $userCheck->update();

            $success = [
                'token' => $token
            ];

            return $this->sendResponse($success, 'OTP Verified');
        } else {
            return $this->sendError('Invalid OTP', ['error' => 'Unauthorised'], 406);
        }
    }

    public function passwordChange(Request $request): JsonResponse
    {


        $rules = [
            'username' => 'required',
            'token' => 'required',
            'password' => 'required',
        ];

        $messages = [
            'username.required' => 'Username is required.',
            'token.required' => 'Token is required.',
            'password.required' => 'Password is required.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return $this->sendError('Validation Error', $validator->errors(), 422);
        }



        $username = $request->username;
        $token = $request->token;
        $password = $request->password;

        $userCheck = User::where('username', $username)->where('otp_token', $token)->first();

        if ($userCheck != null && $userCheck != '') {

            $userCheck->password = Hash::make($password);
            $userCheck->otp = null;
            $userCheck->otp_token = null;
            $userCheck->update();

            $success = [];

            return $this->sendResponse($success, 'Successfully password changed');
        } else {
            return $this->sendError('Invalid Token', ['error' => 'Unauthorised']);
        }
    }

    public function logout(Request $request): JsonResponse
    {

        $rules = [
            'fcm_token' => 'required',

        ];

        $messages = [
            'fcm_token.required' => 'FCM Token is required.',

        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return $this->sendError('Validation Error', $validator->errors(), 422);
        }

        if (Auth::user()) {

            $user = Auth::user();
            $token = $request->input('fcm_token');

            $user->fcmTokens()->where('token', $token)->delete();

            $request->user()->token()->delete();
            $success = [];

            return $this->sendResponse($success, 'User logout successfully.');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
        }
    }

    public function userProfile(Request $request): JsonResponse
    {

        if (Auth::user()) {

            $user = Auth::user();

            $user_array = array(
                'username' => $user->username,
                'name' => $user->name,
                'email' => $user->email,
                'role_id' => $user->role,
                'role_name' => getUserRoleName($user->id),
                'designation_id' => $user->designation,
                'designation_name' => $user->user_designation_name,
                'company_id' => $user->company,
                'company_name' => $user->companyInfo?->company_name,
                'division_id' => $user->division,
                'division_name' => $user->divisionInfo?->division_name,
                'department_id' => $user->department,
                'department_name' => $user?->departmentInfo?->department_name,
                'profile_image' => url(profileImage(Auth::id()))
            );

            $success = [
                'user_details' => $user_array
            ];

            return $this->sendResponse($success, 'User Details');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
        }
    }
}
