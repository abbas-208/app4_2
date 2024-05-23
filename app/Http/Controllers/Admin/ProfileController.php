<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Rules\PasswordRule;
use App\Models\User;
use App\Models\Zone;
use DB;
use Response;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display profile update form.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('admin.profileHome', [
            'user' => $request->user()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $zones = Zone::all();
        return view('admin.updateProfile', [
            'user' => $request->user(),
            'zones' => $zones
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
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

        $userObj = User::find($request->user()->id);
        if($userObj)
        {
            //dd($userObj);
            $userObj->trading_position = $request->tradingPosition;
            $userObj->zone_id = $request->zone;
            if ($request->user()->isServiceManager == 1) {
                $userObj->isServiceManager = 1;
            }
            $userObj->address_line_1 = $request->addressLine1;
            $userObj->address_line_2 = $request->addressLine2;
            $userObj->city = $request->inputCity;
            $userObj->state = $request->inputState;
            $userObj->post_code = $request->post_code;

            $userObj->save();
        }

        return redirect()->route('profile.edit', $userObj->id)
                        ->with('success','Profile updated successfully');
    }

    /**
     * Show the form for editing the passowrd
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changePassword(Request $request)
    {
        return view('admin.changePassword', [
            'user' => $request->user()
        ]);
    }

    /**
     * Update the password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request, User $user)
    {
       $current_password = $request->current_password;

       $user = $request->user();

        if (Hash::check($current_password, $user->password)) {

            $request->validate([
                'current_password' => 'required',
                'password' => [
                    'required',
                    new PasswordRule(),
                    'confirmed'
                ],
            ],
            [
                'password.required' => 'New Password field is required',
            ]);

            if (Hash::check($request->password, $user->password)) {
                return redirect()->back()->with('error', 'New password cannot be the same as your old password.');
           }

            $user->fill([
                'password' => Hash::make($request->password)
            ])->save();

            return redirect()->route('profile.index', $request->user()->id)
                            ->with('success','Password updated successfully');
        } else {
            return redirect()->back()->with('error', 'Current password did not match! Try Again.');
        }
    }

    /**
     * Show the form for editing the balance.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changeBalance(Request $request)
    {
        return view('admin.changeBalance', [
            'user' => $request->user()
        ]);
    }

    /**
     * Update the balance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateBalance(Request $request, User $user)
    {
        $request->validate([
            'balance' => ['required', 'numeric']
        ],
        [
            'balance.required' => 'Balance field is required',
            'balance.numeric' => 'Invalid balance value',
        ]);

       $userObj = $request->user();

       $userObj->fill([
            'balance' => $request->balance
        ])->save();

        return redirect()->route('profile.index', $userObj->id)
                        ->with('success','Balance updated successfully');
    }
}
