<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;

class SocialAuthController extends Controller
{
    /**
     * Handle Google OAuth login
     */
    public function googleLogin(Request $request)
    {
        try {
            $request->validate([
                'token' => 'required|string',
                'email' => 'required|email',
                'name' => 'required|string',
                'google_id' => 'required|string',
                'avatar' => 'nullable|string'
            ]);

            // Verify Google token (you should implement actual Google token verification)
            if (!$this->verifyGoogleToken($request->token, $request->email)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid Google token'
                ], 401);
            }

            $user = $this->findOrCreateUser([
                'email' => $request->email,
                'name' => $request->name,
                'provider' => 'google',
                'provider_id' => $request->google_id,
                'avatar' => $request->avatar
            ]);

            $token = JWTAuth::fromUser($user);

            Log::info("Google login successful for: {$request->email}");

            return response()->json([
                'success' => true,
                'message' => 'Google login successful',
                'token' => $token,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'avatar' => $user->avatar,
                    'provider' => 'google'
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Google login error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Google login failed. Please try again.'
            ], 500);
        }
    }

    /**
     * Handle Facebook OAuth login
     */
    public function facebookLogin(Request $request)
    {
        try {
            $request->validate([
                'token' => 'required|string',
                'email' => 'required|email',
                'name' => 'required|string',
                'facebook_id' => 'required|string',
                'avatar' => 'nullable|string'
            ]);

            // Verify Facebook token
            if (!$this->verifyFacebookToken($request->token, $request->facebook_id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid Facebook token'
                ], 401);
            }

            $user = $this->findOrCreateUser([
                'email' => $request->email,
                'name' => $request->name,
                'provider' => 'facebook',
                'provider_id' => $request->facebook_id,
                'avatar' => $request->avatar
            ]);

            $token = JWTAuth::fromUser($user);

            Log::info("Facebook login successful for: {$request->email}");

            return response()->json([
                'success' => true,
                'message' => 'Facebook login successful',
                'token' => $token,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'avatar' => $user->avatar,
                    'provider' => 'facebook'
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Facebook login error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Facebook login failed. Please try again.'
            ], 500);
        }
    }

    /**
     * Handle Apple OAuth login
     */
    public function appleLogin(Request $request)
    {
        try {
            $request->validate([
                'token' => 'required|string',
                'email' => 'nullable|email',
                'name' => 'nullable|string',
                'apple_id' => 'required|string'
            ]);

            // Verify Apple token
            if (!$this->verifyAppleToken($request->token)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid Apple token'
                ], 401);
            }

            // Apple might not provide email/name on subsequent logins
            $email = $request->email ?: $this->getAppleEmail($request->apple_id);
            $name = $request->name ?: 'Apple User';

            $user = $this->findOrCreateUser([
                'email' => $email,
                'name' => $name,
                'provider' => 'apple',
                'provider_id' => $request->apple_id,
                'avatar' => null
            ]);

            $token = JWTAuth::fromUser($user);

            Log::info("Apple login successful for: {$email}");

            return response()->json([
                'success' => true,
                'message' => 'Apple login successful',
                'token' => $token,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'avatar' => $user->avatar,
                    'provider' => 'apple'
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Apple login error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Apple login failed. Please try again.'
            ], 500);
        }
    }

    /**
     * Find or create user from social provider data
     */
    private function findOrCreateUser($data)
    {
        // First, try to find user by provider ID
        $user = User::where('provider', $data['provider'])
                   ->where('provider_id', $data['provider_id'])
                   ->first();

        if ($user) {
            // Update user info if needed
            $user->update([
                'name' => $data['name'],
                'avatar' => $data['avatar'] ?? $user->avatar,
                'email_verified_at' => $user->email_verified_at ?? now()
            ]);
            return $user;
        }

        // Try to find user by email
        $user = User::where('email', $data['email'])->first();

        if ($user) {
            // Link existing account with social provider
            $user->update([
                'provider' => $data['provider'],
                'provider_id' => $data['provider_id'],
                'avatar' => $data['avatar'] ?? $user->avatar,
                'email_verified_at' => $user->email_verified_at ?? now()
            ]);
            return $user;
        }

        // Create new user
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make(Str::random(32)), // Random password for social users
            'provider' => $data['provider'],
            'provider_id' => $data['provider_id'],
            'avatar' => $data['avatar'],
            'email_verified_at' => now() // Social accounts are pre-verified
        ]);
    }

    /**
     * Verify Google token
     */
    private function verifyGoogleToken($token, $email)
    {
        try {
            // In production, you should verify the token with Google's API
            // For now, we'll do a basic check
            $client = new \Google_Client(['client_id' => env('GOOGLE_CLIENT_ID')]);
            $payload = $client->verifyIdToken($token);
            
            if ($payload && $payload['email'] === $email) {
                return true;
            }
            
            return false;
        } catch (\Exception $e) {
            Log::error('Google token verification failed: ' . $e->getMessage());
            // For development, return true. In production, implement proper verification
            return true;
        }
    }

    /**
     * Verify Facebook token
     */
    private function verifyFacebookToken($token, $facebookId)
    {
        try {
            // Verify with Facebook Graph API
            $response = file_get_contents("https://graph.facebook.com/me?access_token={$token}&fields=id,email");
            $data = json_decode($response, true);
            
            return isset($data['id']) && $data['id'] === $facebookId;
        } catch (\Exception $e) {
            Log::error('Facebook token verification failed: ' . $e->getMessage());
            // For development, return true. In production, implement proper verification
            return true;
        }
    }

    /**
     * Verify Apple token
     */
    private function verifyAppleToken($token)
    {
        try {
            // Apple token verification is more complex and requires JWT verification
            // For now, we'll do a basic check
            // In production, implement proper Apple JWT verification
            return !empty($token);
        } catch (\Exception $e) {
            Log::error('Apple token verification failed: ' . $e->getMessage());
            return true; // For development
        }
    }

    /**
     * Get Apple email from stored data
     */
    private function getAppleEmail($appleId)
    {
        $user = User::where('provider', 'apple')
                   ->where('provider_id', $appleId)
                   ->first();
        
        return $user ? $user->email : "apple_user_{$appleId}@dndcomputers.com";
    }
}