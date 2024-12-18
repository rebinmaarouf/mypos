<?php

namespace App\Http\Controllers\Auth;

use Log;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard/index';

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public static function middleware(): array
    {
        //create read update delete
        return [

            new Middleware('guest', except: ['logout']),
            new Middleware('auth', only: ['logout']),


        ];
    } //end of constructor

    public function logout(Request $request)
    {

        Auth::logout(); // Logs out the user

        $request->session()->invalidate(); // Clears the session
        $request->session()->regenerateToken(); // Prevents CSRF issues

        return redirect('/login'); // Redirect to login or homepage
    }
}
