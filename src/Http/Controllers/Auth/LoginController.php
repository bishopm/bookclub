<?php

namespace Bishopm\Bookclub\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('bookclub::auth.login');
    }

    public function redirectTo()
    {
        return back()->getTargetUrl();
    }

    public function socialLogin($social)
    {
        return Socialite::driver($social)->redirect();
    }
 
    public function handleProviderCallback($social)
    {
        $userSocial = Socialite::driver($social)->user();
        if ($social=="facebook") {
            $user = User::where(['facebook_id' => $userSocial->getId()])->first();
            $provider_id=$userSocial->getId();
        } else {
            $user = User::where(['google_id' => $userSocial->id])->first();
            $provider_id=$userSocial->id;
        }
        if ($user) {
            Auth::login($user);
            return redirect('/');
        } else {
            $individuals=array();
            $services=explode(',', $this->setting->getkey('worship_services'));
            return view('bookclub::auth.register', ['name' => $userSocial->getName(), 'email' => $userSocial->getEmail(), 'individuals'=>$individuals, 'services'=>$services, 'provider'=>$social, 'provider_id'=>$provider_id]);
        }
    }
}
