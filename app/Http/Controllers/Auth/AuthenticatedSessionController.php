<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = $request->user();

        if ($user && $user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user && $user->role === 'manager') {
            return redirect()->route('manager.dashboard');
        } elseif ($user && $user->role === 'staff_gudang') {
            return redirect()->route('gudang.dashboard');
        } elseif ($user && $user->role === 'staff_logistik') {
            return redirect()->route('logistik.dashboard');
        }

        return redirect('/dashboard');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = Auth::user();

        // Revoke all tokens for Sanctum (ignore return value)
        try {
            if ($user) {
                $user->tokens()->delete();
            }
        } catch (\BadMethodCallException $e) {
            // tokens() method not available
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
