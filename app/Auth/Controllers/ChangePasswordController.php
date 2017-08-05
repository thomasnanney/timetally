<?php

namespace App\Auth\Controllers;

use Illuminate\Http\Request;
use App\Core\Controllers\Controller;
use App\Users\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ChangePassword;
use Illuminate\Support\Facades\Hash;


class ChangePasswordController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function showChangeForm()
    {
        return view('passwords.change');
    }

    public function changePassword(Request $request)
    {
        $user = Auth::user();

        /*
        * Validate all input fields
        */
        $this->validate($request, [
            'oldpassword' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);

        if (Hash::check($request->oldpassword, $user->password)) {
            $user->fill([
                'password' => Hash::make($request->password)
            ])->save();

            $user->notify(new ChangePassword());

            return response()->json([
                'success' => 'true',
                'message' => 'Password successfully changed.'
            ]);

        } else {
            return response()->json([
                'success' => 'false',
                'message' => 'Current password is Incorrect.'
            ]);
        }

    }

}
