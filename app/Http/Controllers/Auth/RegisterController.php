<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Zone;
use App\Rules\PasswordRule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest');
        $this->redirectTo = route('dashboard');
    }

    /**
     * Overridding route of laravel registration method
     *
     * @return view
     */
    public function showRegistrationForm()
    {
        $zones = Zone::all();
        return view("auth.register", compact("zones"));
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => [
                'required',
                new PasswordRule(),
                'confirmed'
            ],
            'tradingPosition' => ['required'],
            'zone' => ['required'],
            'addressLine1' => ['required'],
            'inputCity' => ['required'],
            'inputState' => ['required'],
            'post_code' => ['required'],
        ],
        [
            'addressLine1.required' => 'Address line 1 is required',
            'inputCity.required' => 'required',
            'inputState.required' => 'required',
            'post_code.required' => 'required'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $isServiceManager = 0;
        if($data['tradingPosition'] == 4) {
            $isServiceManager = 1;
            $data['tradingPosition'] = 3;
        }
        if($data['manager'] == 1) {
            $this->redirectTo = route('manageUser');
            Session::put('success', 'User created successfully.');
            User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'zone_id' => $data['zone'],
                'isServiceManager' => $isServiceManager,
                'trading_position' => $data['tradingPosition'],
                'address_line_1' => $data['addressLine1'],
                'address_line_2' => $data['addressLine2'],
                'city' => $data['inputCity'],
                'state' => $data['inputState'],
                'post_code' => $data['post_code']
            ]);

        } else {
            Session::put('success', 'Registration completed successfully. Log in to start your journey!');
            return User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'zone_id' => $data['zone'],
                'trading_position' => $data['tradingPosition'],
                'address_line_1' => $data['addressLine1'],
                'address_line_2' => $data['addressLine2'],
                'city' => $data['inputCity'],
                'state' => $data['inputState'],
                'post_code' => $data['post_code']
            ]);
        }
    }
}
