<?php
declare (strict_types = 1);
namespace App\Http\Controllers;

use App\Mail\OtpMail;
use App\Models\User;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class LoginandLogoutController extends Controller
{
    // public function Logout()
    // {
    //     Auth::logout();
    //     return redirect()->route('login')->with('success', 'User Logout Successfully');
    // }

    public function Log_in(Request $request)
    {
        // Validate the login credentials
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $email = $request->email;
        $password = $request->password;
        $now = Carbon::now();
        $todayDate = $now->toDateTimeString();
        // Attempt to authenticate the user
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            $user = Auth::user();
            if ($user->status == 1) {
                // Log the activity
                $activityLog = [
                    'uuid' => Str::uuid(),
                    'name' => $user->name,
                    'email' => $user->email,
                    'description' => 'has logged in',
                    'date_time' => $todayDate,
                ];
                DB::table('activity_logs')->insert($activityLog);
                // Generate a random 6-digit OTP
                $otp = rand(100000, 999999);
                Session::put('otp_code', $otp);
                Session::put('otp_verified', false);
                // Send OTP email to the authenticated user
                Mail::to($user->email)->send(new OtpMail($otp));
                // Redirect to the OTP verification page
                return redirect()->route('verify.otp');
            } else {
                Auth::logout();
                return redirect()->route('login')->withErrors(['error' => 'Your account is deactivated. Please contact the Admin.']);
            }
        }
        return redirect()->route('login')->withErrors(['error' => 'Invalid credentials. Please try again.']);
    }
    public function Logout()
    {
        $user = Auth::user();
        $name = $user->name;
        $email = $user->email;
        $dt = Carbon::now();
        $todayDate = $dt->toDateTimeString();
        $activityLog = [
            'uuid' => Str::uuid(),
            'name' => $name,
            'email' => $email,
            'description' => 'has logged out',
            'date_time' => $todayDate,
        ];
        DB::table('activity_logs')->insert($activityLog);
        Auth::logout();
        session()->forget('otp_verified');
        return redirect()->route('login')->with('success', 'User Logout Successfully');
    }

    public function verifyaccount()
    {
        return view('auth.verifyaccount');
    }

    public function resetpassword()
    {
        return view('auth.forgot-password');
    }

    public function forgotPassword(Request $request)
    {
        // Validate the request
        $request->validate([
            'email' => 'required|string|email',
            'password' => [
                'required',
                'string',
                'confirmed',
                'min:8', // Minimum 8 characters
                'regex:/[A-Z]/', // At least one uppercase letter
                'regex:/[a-z]/', // At least one lowercase letter
                'regex:/[0-9]/', // At least one digit
                'regex:/[@$!%*#?&]/', // At least one special character
            ],
        ]);

        $email = $request->email;
        $password = $request->password;
        // Check if email exists
        $user = User::where('email', $email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'Email does not exist.']);
        }
        // Update the password
        $user->password = bcrypt($password);
        $user->save();
        // Generate a random 6-digit OTP
        $otp = rand(100000, 999999);
        Session::put('otp_code', $otp);
        Session::put('otp_verified', false);
        // Send OTP email to the user
        Mail::to($user->email)->send(new OtpMail($otp));
        // Redirect to the OTP verification page
        return redirect()->route('verify.otp');
    }
}
