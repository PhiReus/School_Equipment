<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Interfaces\UserServiceInterface;


class ForgotPasswordController extends Controller
{

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }
    public function showLinkRequestForm()
    {
        return view('includes.ForgotPassword');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $this->userService->forgotPassword($request);
        return redirect()->route('login');
    }
}
