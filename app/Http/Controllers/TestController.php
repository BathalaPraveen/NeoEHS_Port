<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

use Kreait\Firebase\Messaging\AndroidConfig;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\WebPushConfig;

use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Test;

use Illuminate\Support\Facades\Crypt;

use DB;
use Exception;

class TestController extends Controller
{

    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index(Request $request)
    {


        try {
            $notifydata = [
                'title' => "test",
                'message' => 'New UAUC ',
                'module_id' => 1,
                'module_type' => 1,
            ];
          //  mobilePushNotification([1], $notifydata);
        } catch (Exception $ex) {
          dd($ex);
        }

        dd("Success");


        echo phpinfo();
        dd('test');
        $batch = $request->batch;
        $batchSize = 500;
        $offset = ($batch - 1) * $batchSize;

        $userdetails = User::where('username', '!=', 'admin')
            ->limit($batchSize)
            ->offset($offset)
            ->get();
        if(count($userdetails) == 0){
            dd('All User Password Updated');
        }

        foreach ($userdetails as $user) {
            $user->password = Hash::make($user->username . "@12345");
            $user->update();
        }




        dd('Successfully update ');


        $encryptedData = 'eyJpdiI6IkVqQ2d2SnJRN0dJSUxHQlVvQTk0cnc9PSIsInZhbHVlIjoiZVpjdnBzeDA1MzFjTWVNMEM2Nm9uQT09IiwibWFjIjoiYTZmOTkyNjE5Y2QxZDUyZGE0MTI4Y2UyY2UwNDMxMzIyMWQwNTAxNGNlNTZhZDUwNGU0OGRkMTAyNDIxNDA3NiIsInRhZyI6IiJ9';
        $key = 'your_secret_key'; // Same key used for encryption

        $decryptedData = Crypt::decryptString($encryptedData, $key);

        dd($decryptedData);

        dd(get_financial_year_dates('20-04-2025'));

        dd(getEndDate($fromdate = '29-04-2024', $addValue = 15, $type = 2, $endDate = "20-05-2025"));

        dd(string_to_array('Hi,This,Is,Gowtham'));

        Test::create(['value' => 'plain test']);

        dd(Test::get()->toArray());
        dd('Inserted');

        dd(get_financial_year_dates('1-4-2023'));

        dd(Hash::make('BHB1638000@12345'));
        dd(getEndDate('24-11-2023', 2, 1));
        dd(auth()->id());
        dd(isAdmin());
        try {
            dd(getUserRoleName(1));
        } catch (\Exception $ex) {
        }

        dd(permitStatusUpdate(48));



        dd(encryptId(34));

        dd(encryptId(17));


        $FcmToken = 'fbObCDAYQomTqmgLRgWw2F:APA91bFKysPU9pTlKACwkwswbsymLbr0Ujw3E0B-jABjU1ura6ul80_lNKGyenkb0tiRpf48Oba6i3NcYisnN5KXTzilT8ac7mfkSS1wz3ze9VkAIumNpefobxVdOJ3RjgJNpBngNdDR';
        $deviceTokens = [$FcmToken];
        $messaging = app('firebase.messaging');

        $message = CloudMessage::fromArray([
            //'token' => $FcmToken,
            'notification' => [
                "title" => "Hi",
                "body" => 'Test Notification',
            ],
        ]);

        $data = $messaging->sendMulticast($message, $deviceTokens);

        //$data =   $messaging->send($message);
        dd($data);
        dd(encryptId(1));
        dd(Cache::get('otp_admin'));
    }

    public function index1(Request $request)
    {
        dd('test', $request->testvalue);
    }
}
