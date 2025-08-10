<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    public function sendOTP(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $email = $request->email;
        
        // Generate 6-digit OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        // Store OTP in database with expiration (15 minutes)
        DB::table('password_resets')->updateOrInsert(
            ['email' => $email],
            [
                'token' => $otp,
                'created_at' => Carbon::now(),
                'expires_at' => Carbon::now()->addMinutes(15)
            ]
        );

        // Send OTP email
        try {
            Mail::send('emails.otp', ['otp' => $otp], function($message) use ($email) {
                $message->to($email);
                $message->subject('Password Reset OTP - DND COMPUTERS');
            });

            return response()->json([
                'success' => true,
                'message' => 'OTP sent successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send OTP. Please try again.'
            ], 500);
        }
    }

    public function verifyOTP(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|string|size:6',
        ]);

        $email = $request->email;
        $otp = $request->otp;

        // Check if OTP exists and is valid
        $resetRecord = DB::table('password_resets')
            ->where('email', $email)
            ->where('token', $otp)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if (!$resetRecord) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired OTP.'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'OTP verified successfully!'
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $email = $request->email;
        $password = $request->password;

        // Update user password
        $user = User::where('email', $email)->first();
        $user->password = Hash::make($password);
        $user->save();

        // Delete used OTP
        DB::table('password_resets')->where('email', $email)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Password reset successfully!'
        ]);
    }
} 