<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\SendSMS;
use App\User;
use Dingo\Api\Routing\Helpers;
use Exception;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use Helpers;
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'device_token' => ['required', 'string'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:11', 'unique:users'],
            'email' => ['string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'church_id' => ['required']
        ]);
        if ($validator->fails()) {
            $errors = collect($validator->errors())->reduce(function ($i, $f) {
                if ($i == '') {
                    return $i . $f;
                } else {
                    return $i . ',' . $f;
                }
            }, '');
            return response()->json(['message' => 'Error registering user', 'errors' => $errors], 422);
        }
        User::create([
            'device_token' => $request['device_token'],
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'phone_number' => $request['phone_number'],
            'email' => $request['email'],
            'church_id' => $request['church_id'],
            'password' => Hash::make($request['password']),
        ]);
        return $this->response->created();
    }

    public function smsCode(Request $request)
    {
        $this->validate($request, [
            'phone' => ['required']
        ]);
        try {
            $code = random_int(1000, 9000);
            dispatch(new SendSMS($request->phone_number, "Hi, Kindly use code: $code to complete your registration."));
            return response()->json([
                'code' => $code,
                'message' => 'success',
            ], 200);
        } catch (Exception $e) {
            return $this->response->error($e->getMessage());
        }

    }
}
