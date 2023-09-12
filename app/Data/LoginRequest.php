<?php

namespace App\Data;

class LoginRequest {
    
    private String $username;
    private String $password;

    public function setUsername(String $username):void
    {
        $this->username = $username;
    }
    public function getUsername():String
    {
        return $this->username;
    }
    public function getPassword():String
    {
        return $this->password;
    }
    public function setPassword(String $password):void
    {
        $this->password = $password;
    }
}
