<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request): \Symfony\Component\HttpFoundation\Response|Response
    {
        return $request->user()->hasVerifiedEmail()
                    ? Inertia::location(route('admin.dashboard', absolute: false))
                    : Inertia::render('Auth/VerifyEmail', ['status' => session('status')]);
    }
}
