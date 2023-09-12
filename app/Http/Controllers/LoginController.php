<?php

namespace App\Http\Controllers;

use App\Data\LoginRequest;
use App\Services\LoginService;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    private LoginService $loginService;
    public function __construct(){
        $this->loginService = new LoginService();
    }
    
    public function loginForm(){
        return view('login', ["title" => "Login"]);
    }

    public function postLogin(Request $request){
        $username = $request->input('username');
        $password = $request->input('password');
        if (empty($username) || empty($password)) {
            return response()->view("login", [
                "title" => "Login",
                "error" => "User or password is required"
            ]);
        }
        $loginRequest = new LoginRequest();
        $loginRequest->setUsername($username);
        $loginRequest->setPassword($password);

        $exist = $this->loginService->findByUsername($loginRequest);

        if ($exist) {
                $request->session()->put("user", $username);
                return redirect("/");
        }
        return response()->view("login", [
            "title" => "Login",
            "error" => "User or password is wrong"
        ]);
    }
    public function logout(Request $request)
    {
        $request->session()->forget("user");
        return redirect("/");
    }
}
