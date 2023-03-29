<?php

namespace App\Http\Controllers\User;

use App\Handler\UserHandler;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Socialite;
use Mail;
use Session;

class ConnectGmailController extends Controller
{

    /**
     * @param UserHandler $userHandler
     */
    public function __construct(private UserHandler $userHandler)
    {

    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function handleGoogleCallback(Request $request): RedirectResponse
    {
            return $this->userHandler->handleGoogleCallback($request);
    }

}
