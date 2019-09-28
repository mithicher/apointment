<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Hash;

class AccountSettingsController extends Controller
{

    /**
     * Update the password for the user.
     *
     * @param  Request  $request
     * @return Response
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'old' => 'required',
            'password' => 'required|min:6|confirmed',
        ], [
            'old.required' => 'Enter your current password'
        ]);
 
        $user = User::find(auth()->user()->id);
        $hashedPassword = $user->password;
 
        if (Hash::check($request->old, $hashedPassword)) {
            //Change the password
            $user->fill([
                'password' => Hash::make($request->password)
            ])->save();
 
            return response([
                'status' => 'success',
                'message' => 'Password updated!'
            ], 200);
        } else {
            return response([
                'status' => 'error',
                'errors' => [
                    'old' => ["Current password is incorrect"]
                ]
            ], 422);
        }
    }
}
