<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\ATAR\UAUCController;

class UaucRemainder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:uauc-remainder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Timeframe to close the UAUC (1ST REMINDER 2 WEEKS + 2ND REMINDER 2 WEEKS), MORE THAN 1 MONTH OVERDUE';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $uaucController = new UAUCController();

        try{
            $uaucController->UAUCCloseRemainderSecondWeek(); 
            $uaucController->UAUCCloseRemainderFourthWeek(); 
            Session::flash('success','Remainder Send Successfully!');
        }catch(Exception $ex){
            report($ex);
            Session::flash('error','Something Went Wrong!');

        }
    }
}
