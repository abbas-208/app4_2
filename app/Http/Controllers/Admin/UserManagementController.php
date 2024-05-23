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

class UserManagementController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('manager');
    }

    /**
     * Display profile update form.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::all();
        return view('admin.userManagement', [
            'users' => $users
        ]);
    }

    /**
     * Show the form for editing the passowrd
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function createUser(Request $request)
    {
        $zones = Zone::all();
        return view('admin.createUser', [
            'zones' => $zones
        ]);
    }

    /**
     * Activate User.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function activateUser(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        $user->fill([
                'isActivated' => 1
            ])->save();

        return redirect()->route('manageUser')
                        ->with('success','User activated successfully.');
    }

    /**
     * Deactivate User.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deactivateUser(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        $user->fill([
                'isActivated' => 0
            ])->save();

        return redirect()->route('manageUser')
                        ->with('success','User deactivated successfully.');
    }

    /**
     * Delete User.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteUser(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        $user->delete();

        return redirect()->route('manageUser')
                        ->with('success','User deleted successfully. User Name - "'.$user->name.'"');
    }
}
