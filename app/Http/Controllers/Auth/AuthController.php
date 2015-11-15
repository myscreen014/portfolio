<?php

namespace App\Http\Controllers\Auth;

use App\Models\UserModel;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

/* My uses */
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    public function redirectPath() {
        if (Auth::user()->role == 'admin') {
            return route(\Illuminate\Support\Facades\Config::get('auth.redirectPathRouteAdmin'));    
        } else {
            return route(\Illuminate\Support\Facades\Config::get('auth.redirectPathRouteSite'));    
        }
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
    
        $user = new UserModel();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = bcrypt($data['password']);
        $user->role = 'user';
        $user->key = md5(Config::get('app.key').$data['name'].$data['email']);
        $user->confirmed = false;
        if ($user->save()) {
            $user->sendEmailConfirmation();
        }
        
        return $user;

    }

    public function confirmation($email, $secure) {
        varlog($email);
        varlog($secure);
    }
}
