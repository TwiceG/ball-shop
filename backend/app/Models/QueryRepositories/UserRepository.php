<?php

namespace App\Models\QueryRepositories;

use App\Models\User;
use Carbon\Carbon;

class UserRepository
{
    public function register($name, $email, $hashedPassword)
    {
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => $hashedPassword,
        ]);

        return $user->id;
    }

    public function changePassword($email, $hashedNewPassword)
    {
        $user = User::where('email', $email)->first();
        if ($user) {
            $user->password = $hashedNewPassword;
            $user->updated_at = Carbon::now();
            $user->save();
            return true;
        }
        return false;
    }

    public function getUserByEmail($email)
    {
        return User::where('email', $email)->first();
    }

    public function getUserByToken($token)
    {
        return User::where('reset_token', $token)->first();
    }

    public function clearResetToken($email)
    {
        $user = User::where('email', $email)->first();
        if ($user) {
            $user->reset_token = null;
            $user->save();
            return true;
        }
        return false;
    }

    public function addVerifyTokenToUser($token, $email)
    {
        $user = User::where('email', $email)->first();
        if ($user) {
            $user->reset_token = $token;
            $user->save();
            return true;
        }
        return false;
    }
}
