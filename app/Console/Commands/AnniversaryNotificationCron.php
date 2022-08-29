<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Log;
use Mail;

class AnniversaryNotificationCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'anniversary:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Log::info('Cron Job Started');
        $i = 0;
        $users = \App\Employee::whereMonth('joining_date', '=', date('m'))->whereDay('joining_date', '=', date('d'))->get();
        // $users = \App\Models\User::where('email', 'umair.subhani1122@gmail.com')->first();
        foreach($users as $user)
        {
//            $total_users = \App\Employee::get();
//            foreach ($total_users as $total_employees){
                Mail::to($user->email)->send(new \App\Mail\AnniversaryEmail($user));
//            }
            $i++;
        }

        $this->info($i.'Anniversary messages sent successfully!');
    }
}
