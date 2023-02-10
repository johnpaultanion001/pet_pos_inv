<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

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


     public function googleLogin(Request $request){
    	$checkUser = User::where('social_id',$request->uid)->first();
    	if($checkUser){
    		Auth::loginUsingId($checkUser->id, true);
    		return response()->json([
    			"status" => "success"
    		]);
    	}else{
    		$user = new User;
    		$user->social_id = $request->uid;
    		$user->email = $request->email;
            $user->name = $request->displayName;
    		$user->provider = "google";
            $user->password = '$2y$10$zPiaTbYwkxYcejFmEimhWedeAogTJvEb/yGmBVx390ihhPFy8r896';
    		$user->save();
			
    		Auth::loginUsingId($user->id, true);
    		return response()->json([
    			"status" => "success"
    		]);
    	}
    }

    public function redirectPath(){
        if(Auth::user()->role == 'customer'){
            return route('home');
        }else if(Auth::user()->role == 'admin'){
            return route('admin.dashboard');
        }
    }
}
