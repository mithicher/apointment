<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\Enums\UserType;

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
    // protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // protected function authenticated(Request $request, $user)
    // {
    //     return $request->user;

    //     // User role
    //     // $role = Auth::user()->user_type;
    
    //     // // Check user role
    //     // switch (UserType::getKey($role)) {
    //     //     case 'Owner':
    //     //         return '/admin/dashboard';
    //     //         break;
    //     //     case 'Client':
    //     //         return '/';
    //     //         break;
    //     //     default:
    //     //         return '/login';
    //     //         break;
    //     // }
    // }
}
