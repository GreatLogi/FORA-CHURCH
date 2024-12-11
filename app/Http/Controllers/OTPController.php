<?php
declare (strict_types = 1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OTPController extends Controller
{
    public function showVerifyOtpForm()
    {
        return view('auth.otp');
    }
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp_code' => 'required|digits:6',
        ]);

        $otp_code = Session::get('otp_code');
        if ($request->otp_code == $otp_code) {
            Session::put('otp_verified', true);
            Session::forget('otp_code');
            return redirect()->route('dashboard')->with('success', 'OTP verified successfully!');
        } else {
            return redirect()->back()->withErrors(['otp' => 'Invalid OTP. Please try again.']);
        }
    }

    public function resendOtp(Request $request)
    {
        $otp_code = rand(100000, 999999);
        Session::put('otp_code', $otp_code);

        // Send the OTP email/SMS (implement logic as needed).
        Mail::to($request->email)->send(new OtpMail($otp_code));

        return redirect()->back()->with('success', 'OTP has been resent.');
    }

    // public function verifyOtp(Request $request)
    // {
    //     $request->validate([
    //         'otp_code' => 'required|numeric',
    //     ]);
    //     $otp_code = Session::get('otp_code');
    //     if ($request->otp_code == $otp_code) {
    //         Session::put('otp_verified', true);
    //         Session::forget('otp_code');
    //         return redirect()->route('dashboard');
    //     } else {
    //         return redirect()->route('verify.otp')->withErrors(['otp' => 'Invalid OTP. Please try again.']);
    //     }
    // }

}
