<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Log;
use Mail;

class BirthdayNotificationCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'birthday:cron';

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
        $users = \App\Employee::whereMonth('date_of_birth', '=', date('m'))->whereDay('date_of_birth', '=', date('d'))->get();
        // $users = \App\Models\User::where('email', 'umair.subhani1122@gmail.com')->first();
        foreach($users as $user)
        {
            Mail::to($user->email)->send(new \App\Mail\BirthdayEmail($user));
            $total_users = \App\Employee::where('id', '!=', $user->id)->get();
            foreach ($total_users as $total_employees){
                Mail::to($total_employees->email)->send(new \App\Mail\BirthdayEmail($user));
            }
            $i++;
        }

        $this->info($i.'Birthday messages sent successfully!');
    }
}
