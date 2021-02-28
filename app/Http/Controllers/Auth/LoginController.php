<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Dingo\Api\Routing\Helpers;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    use Helpers;
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
    public function login(Request $request)
    {
        $this->validate($request, [
            'phone' => ['required'],
            'password' => ['required'],
        ]);
        $user = User::where('phone_number', $request->phone)->first();
        if ($user && Hash::check($request->input('password'), $user->password)) {
            Auth::login($user);
            $token_name = Str::random(8);
            $token = $request->user()->createToken($token_name)->accessToken;
            return response()->json(['token' => $token, 'user' => $request->user()], 200);
        } else {
            return response()->json(['message' => 'Wrong email and password'], 401);
        }
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        if ($user) {
            $user->token()->revoke();
            return $this->response->array([
                'message' => 'Successfully logged out',
            ], 204);
        } else {
            return $this->response->array([
                'message' => 'User unauthenticated',
            ], 404);
        }
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
