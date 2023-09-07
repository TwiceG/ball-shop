<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\SendTOTPToken;
use Illuminate\Http\Request;
use App\Models\QueryRepositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use OTPHP\TOTP;
use OTPHP\TOTPInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;
use PragmaRX\Google2FAQRCode\Google2FA;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(Request $request)
    {

        $name = $request->name;
        $email = $request->email;
        $hashedPassword = Hash::make($request->password);

        $userRegistered = $this->userRepository->register($name, $email, $hashedPassword);


        if ($userRegistered) {
            $user = $this->userRepository->getUserByEmail($email);

            return response()->json([
                'message' => 'User registered successfully',
                'user' => $user
            ], Response::HTTP_CREATED);
        } else {
            return response()->json(['message' => 'User registration failed'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $email = $user->email;

            // Generate and send 2FA token via email
//            $twoFactorToken = $this->generate2FAToken();
//            $this->send2FAToken($email, $twoFactorToken);

            session([
                'userId' => $user->id,
                'email' => $user->email,
                'username' => $user->username,
//                'twoFactorToken' => $twoFactorToken, // Store 2FA token in session for verification
            ]);

            return response()->json([
                'user' => $user,
                'message' => "Login successful!",
            ]);
        } else {
            // Authentication failed
            return response()->json(['message' => 'Invalid credentials'], Response::HTTP_UNAUTHORIZED);
        }
    }

    public function generate2FAToken()
    {
        $totp = TOTP::create();

        return $totp->now();
    }

    public function send2FAToken($email, $totpToken)
    {
        // Send the TOTP token via email
        Mail::to($email)->send(new SendTOTPToken($totpToken));
        return response()->json(['message' => 'TOTP token sent to your email']);
    }



    public function verify2FAToken(Request $request)
    {
        $inputToken = $request->input('twoFactorToken');
        $storedToken = session('twoFactorToken');

        if ($inputToken === $storedToken) {
            // Successfully verified, now log in the user
            Auth::loginUsingId(session('userId'));

            // Clear the stored 2FA token
            $request->session()->forget('twoFactorToken');

            return response()->json(['message' => 'Two-factor authentication successful']);
        } else {
            // Invalid 2FA token
            return response()->json(['message' => 'Invalid two-factor authentication token'], Response::HTTP_UNAUTHORIZED);
        }
    }



    public function logout()
    {
        Auth::logout();
        Session::flush();
        return response()->json(['message' => 'Logged out successfully']);
    }

        public function changePassword(Request $request)
    {
        $oldPassword = $request->oldPassword;
        $newPassword = $request->newPassword;
        $email = session('email');
        $user = $this->userRepository->getUserByEmail($email);

        if ($user && Hash::check($oldPassword, $user->password)) {
            $hashedNewPassword = Hash::make($newPassword);
            $this->userRepository->changePassword($email, $hashedNewPassword);
            return response()->json(['message' => 'Password changed successfully!'], Response::HTTP_ACCEPTED);
        } else {
            return response()->json(['message' => 'Error, wrong password!'], Response::HTTP_UNAUTHORIZED);
        }
    }


    public function getToken(Request $request)
    {
        $email = $request->input('email');

        // Generate a reset token (UUID)
        $resetToken = Uuid::uuid4()->toString();
        $this->userRepository->addVerifyTokenToUser($resetToken, $email);
        return response()->json(['message' => 'Reset token sent successfully', 'token' => $resetToken]);
    }

    public function resetPassword(Request $request)
    {
        $resetToken = $request->input('token');
        $user = $this->userRepository->getUserByToken($resetToken);
        $email = $user->email;
        $newPassword = $request->input('newPassword');



        if ($user && $newPassword) {
            // Reset the user's password
            $hashedNewPassword = Hash::make($newPassword);
            $this->userRepository->changePassword($email, $hashedNewPassword);

            // Clear the reset token
            $this->userRepository->clearResetToken($email);

            return response()->json(['message' => 'Password reset successfully'], Response::HTTP_OK);
        } else {
            return response()->json(['message' => 'Invalid email or reset token'], Response::HTTP_BAD_REQUEST);
        }
    }

}

