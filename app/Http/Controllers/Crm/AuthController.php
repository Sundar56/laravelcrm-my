<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\MessageBag;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Jobs\sendEmailJob;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return redirect()->route('crm.dashboard');
        }
        return view('auth.login');
    }
    public function userlogin(Request $request)
    {
        $input = $request->all();
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);

        $remember = $request->has('remember');
        $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
        $password =  $input['password'];
        $user = User::where([[$fieldType, $input['username']]])->first();
      
        if (isset($user) && Hash::check($password, $user->password)) {        
            Auth::login($user);       
            $roleId=Auth::user()->roles()->first()->id;
            // dd($roleId);
            if ($remember) {
                Cookie::queue('remembered_user', $request->username, env('COOKIE_LIFETIME'));
                Cookie::queue('remembered_pass', $request->password, env('COOKIE_LIFETIME'));
            }else{

                Cookie::queue(Cookie::forget('remembered_user'));
                Cookie::queue(Cookie::forget('remembered_pass'));
            }
            Session::put('activeroleid', $roleId);
            return redirect()->route('crm.dashboard')->withSuccess('Signed in');
        } else {
            // dd('error');
            $errors = new MessageBag(['password' => ['Email and/or password invalid.']]);
            return Redirect::back()->withErrors($errors);
        }
    }
    public function signOut(Request $request)
    {
        Session::flush();
        Auth::logout();    
        $request->session()->invalidate();
        $request->session()->regenerateToken();  
        return Redirect('/crm/login')->withSuccess('You have been logged out');
    }
    public function changePassword(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'old_password' => 'required',
                'new_password' => 'required|min:5|different:old_password',
                'confirm_password' => 'required|same:new_password',
            ], [
                'old_password.required' => 'Old password required.',
                'new_password.required' => 'New password required.',
                'new_password.min' => 'New password must be at least 5 characters.',
                'new_password.different' => 'New password cannot be the same as the old password.',
                'confirm_password.required' => 'Confirm password is required.',
                'confirm_password.same' => 'Confirm password must match the new password.',
            ]);


            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 422);
            }

            $userID = $request->auth_id;
            $user = User::find($userID);

            if (!Hash::check($request->old_password, $user->password)) {
                return response()->json(["old_password" => "Old password doesn't match!"], 422);
            }
            // Change Password
            $user->password = Hash::make($request->new_password);
            $user->save();

            return response()->json(["success" => "Password changed successfully!"]);
        } catch (\Exception $e) {
            // Directly return the error message
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function forgotPassword()
    {
        return view('auth.forgotpassword');
    }
    public function sendResetLink(Request $request)
    {
        $request->validate(['username' => 'required|email|exists:users,email']);

        $user = User::where('email', $request->username)->first();
        // Generate a new password
        $newPassword = Str::random(10);
        $user->password = Hash::make($newPassword);
        $user->update([
            'password' => $user->password
        ]);
        // Dispatch the job to send the email
        SendEmailJob::dispatch($user->email, $newPassword, $user->name);
        // Set a flash message
        session()->flash('status', 'Password reset link has been sent to your email.');

        return back()->with('status', 'Password reset email sent!');
    }
    public function resetpass()
    {
        return view('auth.reset_password_email');
    }
}
