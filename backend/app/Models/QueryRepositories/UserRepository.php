<?php

namespace App\Models\QueryRepositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class UserRepository
{
    public function register($name, $email, $hashedPassword)
    {

        $userId = DB::table('users')->insertGetId([
                'name'=>$name,
                'email'=>$email,
                'password'=>$hashedPassword,
            ]);


        return $userId;

    }

    public function changePassword($email, $hashedNewPassword)
    {
        return DB::table('users')
            ->where('email', $email)
            ->update(['password'=> $hashedNewPassword]);
    }

    public function getUserByEmail($email)
    {
        return DB::table('users')
            ->where('email', $email)
            ->first();
    }

    public function getUserByToken($token)
    {
        return DB::table('users')
            ->where('reset_token', $token)
            ->first();
    }

    public function clearResetToken($email)
    {
        DB::table('users')
            ->where('email', $email)
            ->update(['reset_token' => null]);
    }


    public function addVerifyTokenToUser($token, $email)
    {
        return DB::table('users')
            ->where('email', $email)
            ->update(['reset_token'=> $token]);
    }
}


