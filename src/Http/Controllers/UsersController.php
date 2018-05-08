<?php

namespace Bishopm\Bookclub\Http\Controllers;

use Auth;
use JWTAuth;
use Bishopm\Bookclub\Models\User;
use Bishopm\Bookclub\Models\LinkedSocialAccount;
use Bishopm\Bookclub\Repositories\UsersRepository;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * @var UserRepository
     */
    private $user;

    public function __construct(UsersRepository $user)
    {
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return $this->user->all();
    }

    /**
     * Login or create user
     *
     * @return Response
     */
    public function login(Request $request)
    {
        $account = LinkedSocialAccount::where('provider_name', $request->provider)->where('provider_id', $request->provider_id)->first();
        if ($account) {
            return User::with('accounts')->find($account->user_id);
        } else {
            $user = User::create(['name' => $request->name, 'authorised'=>0]);
            $user->image = $request->image;
            $user->save();
            $user->accounts()->create(['provider_name'=>$request->provider,'provider_id'=>$request->provider_id]);
            return $user;
        }
    }

    /**
     * Display an individual resource.
     *
     * @return Response
     */
    public function show($id)
    {
        return $this->user->find($id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */

    public function store(Request $request)
    {
        return $this->user->create($request->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  User $user
     * @param  Request $request
     * @return Response
     */
    public function update(User $user, Request $request)
    {
        $user = $this->user->update($user, $request->all());
        return $user;
    }

    public function authorise($id, Request $request)
    {
        $user = User::find($id);
        if ($request->action == "authorise") {
            return $this->user->update($user, ['authorised'=>1]);
        } elseif ($request->action == "delete") {
            return "deleting";
        }
        return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User $user
     * @return Response
     */
    public function destroy(User $user)
    {
        $this->user->destroy($user);
        return "deleted!";
    }
}
