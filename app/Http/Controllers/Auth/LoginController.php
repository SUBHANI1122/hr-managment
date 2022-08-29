<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\IpSetting;
use App\Notifications\AnniversaryNotification;
use App\Notifications\BirthdayNotification;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Mail;
use Log;

class LoginController extends Controller
{

    use AuthenticatesUsers;

    //redirect to the login page

    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

     // over riding the method for custom redirecting after login
     protected function authenticated(Request $request, $user)
     {

        if ($user->role_users_id == 1)
        {

            if ($user->last_login_date !== date("Y/m/d")){
                $user_anniversary = \App\Employee::whereMonth('joining_date', '=', date('m'))->whereDay('joining_date', '=', date('d'))->where('id', $user->id)->first();
                $notifiable = $user;
                if ($user_anniversary){
                    Notification::send($notifiable,new AnniversaryNotification($user_anniversary));
                    Mail::to($user->email)->send(new \App\Mail\AnniversaryEmail($user));
                }

                $user_birthday = \App\Employee::whereMonth('date_of_birth', '=', date('m'))->whereDay('date_of_birth', '=', date('d'))->where('id', $user->id)->first();
                if ($user_birthday){
                    Notification::send($notifiable,new BirthdayNotification($user_birthday));
                    Mail::to($user->email)->send(new \App\Mail\BirthdayEmail($user));
                }
            }
            //saving login timestamps and ip after login
            $user->timestamps = false;
            $user->last_login_date = Carbon::now()->toDateTimeString();
            $user->last_login_ip = $request->ip();
            $user->save();
            return redirect('/admin/dashboard');
        } // if client
        elseif ($user->role_users_id == 3)
        {
            //saving login timestamps and ip after login
            $user->timestamps = false;
            $user->last_login_date = Carbon::now()->toDateTimeString();
            $user->last_login_ip = $request->ip();
            $user->save();
            return redirect('/client/dashboard');
        } //if employee
        else
        {
            if ($user->last_login_date !== date("Y/m/d")){
                $user_anniversary = \App\Employee::whereMonth('joining_date', '=', date('m'))->whereDay('joining_date', '=', date('d'))->where('id', $user->id)->first();
                $notifiable = $user;
                if ($user_anniversary){
                    Notification::send($notifiable,new AnniversaryNotification($user_anniversary));
                    Mail::to($user->email)->send(new \App\Mail\AnniversaryEmail($user));
                }

                $user_birthday = \App\Employee::whereMonth('date_of_birth', '=', date('m'))->whereDay('date_of_birth', '=', date('d'))->where('id', $user->id)->first();
                if ($user_birthday){
                    Notification::send($notifiable,new BirthdayNotification($user_birthday));
                    Mail::to($user->email)->send(new \App\Mail\BirthdayEmail($user));
                }
            }
            //saving login timestamps and ip after login
            $user->timestamps = false;
            $user->last_login_date = Carbon::now()->toDateTimeString();
            $user->last_login_ip = $request->ip();
            $user->save();
            return redirect('/employee/dashboard');
        }
    }


	public function username()
	{
		return 'username';
	}

}
