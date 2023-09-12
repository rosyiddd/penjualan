<?php

namespace App\Services;

use App\Data\LoginRequest;
use App\Models\Login;

class LoginService {

    public function findByUsername(LoginRequest $loginRequest):bool
    {
        $user = Login::where('user', $loginRequest->getUsername())
                ->where('password', $loginRequest->getPassword())
                ->first();
        if($user){
            return true;
        }

        return false;
    }
}
