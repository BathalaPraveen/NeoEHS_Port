<?php

namespace App\Http\Controllers\Cron;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Session;

class CronController extends Controller
{
    public function queueHigh()
    {
        $queueLength = Queue::size('high');
        if ($queueLength > 0) {

            $options = [
                '--sleep' => 3,
                '--tries' => 3,
                '--queue' => 'high',
                '--timeout' => 600,
                '--max-jobs' => 10,
            ];

            $exitCode = Artisan::call('queue:work', $options);
            Session::invalidate();
            return response()->json(['message' => 'Queue High work command executed successfully',  'exit_code' => $exitCode]);
        } else {
            Session::invalidate();
            return response()->json(['message' => 'No jobs in the high queue to process', 'exit_code' => 0]);
        }
    }

    public function queueDefault()
    {
        $queueLength = Queue::size('default');
        if ($queueLength > 0) {
            $options = [
                '--sleep' => 3,
                '--tries' => 3,
                '--queue' => 'default',
                '--timeout' => 600,
                '--max-jobs' => 10,
            ];

            $exitCode = Artisan::call('queue:work', $options);
            Session::invalidate();
            return response()->json(['message' => 'Queue High work command executed successfully',  'exit_code' => $exitCode]);
        } else {
            Session::invalidate();
            return response()->json(['message' => 'No jobs in the high queue to process', 'exit_code' => 0]);
        }
    }

    public function queueEmail()
    {
        $queueLength = Queue::size('email');
        if ($queueLength > 0) {
            $options = [
                '--sleep' => 3,
                '--tries' => 3,
                '--queue' => 'email',
                '--timeout' => 600,
                '--max-jobs' => 10,
            ];

            $exitCode = Artisan::call('queue:work', $options);
            Session::invalidate();
            return response()->json(['message' => 'Queue High work command executed successfully',  'exit_code' => $exitCode]);
        } else {
            Session::invalidate();
            return response()->json(['message' => 'No jobs in the high queue to process', 'exit_code' => 0]);
        }
    }

    public function queueEmpImport()
    {
        $queueLength = Queue::size('empimport');
        if ($queueLength > 0) {

            $options = [
                '--sleep' => 3,
                '--tries' => 3,
                '--queue' => 'empimport',
                '--timeout' => 900,
                '--max-jobs' => 1,
            ];

            $exitCode = Artisan::call('queue:work', $options);
            Session::invalidate();
            return response()->json(['message' => 'Queue High work command executed successfully',  'exit_code' => $exitCode]);
        } else {
            Session::invalidate();
            return response()->json(['message' => 'No jobs in the high queue to process', 'exit_code' => 0]);
        }
    }

    public function queueConImport()
    {
        $queueLength = Queue::size('conimport');
        if ($queueLength > 0) {
            $options = [
                '--sleep' => 3,
                '--tries' => 1,
                '--queue' => 'conimport',
                '--timeout' => 900,
                '--max-jobs' => 1,
            ];

            $exitCode = Artisan::call('queue:work', $options);
            Session::invalidate();
            return response()->json(['message' => 'Queue High work command executed successfully',  'exit_code' => $exitCode]);
        } else {
            Session::invalidate();
            return response()->json(['message' => 'No jobs in the high queue to process', 'exit_code' => 0]);
        }
    }

    public function UAUCRemainder()
    {
        try {
            Artisan::call('app:uauc-remainder');
        } catch (Exception $ex) {

        }
    }
}
