<?php

namespace Bishopm\Bookclub\Http\Controllers\Auth;

use Socialite;
use Exception;
use Bishopm\Bookclub\Repositories\SocialAccountService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;

class SocialAccountController extends Controller
{
    /**
     * Redirect the user to the Provider authentication page.
     *
     * @return Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information
     *
     * @return Response
     */
    public function handleProviderCallback(SocialAccountService $accountService, $provider)
    {
        try {
            $user = Socialite::with($provider)->user();
        } catch (Exception $e) {
            return redirect('/login');
        }
        $authUser = $accountService->findOrCreate(
            $user,
            $provider
        );
        auth()->login($authUser, true);
        return redirect()->to('/');
    }

    public function showLoginForm()
    {
        return view('bookclub::auth.login');
    }
}
