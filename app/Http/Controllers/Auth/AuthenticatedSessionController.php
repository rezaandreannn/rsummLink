<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\Auth\LoginRequest;

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
        // $request->authenticate();

        // $request->session()->regenerate();

        // return redirect()->intended(RouteServiceProvider::HOME);
        $credentials = $request->only('identifier', 'password');

        $fieldType = filter_var($credentials['identifier'], FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        // Cari pengguna berdasarkan login (email atau name)
        $user = User::where($fieldType, $credentials['identifier'])->first();

        // Jika pengguna ditemukan dan statusnya tidak aktif
        if ($user && $user->status !== 'aktif') {
            return back()->withErrors([
                'identifier' => __('auth.active'),
            ])->onlyInput('identifier');
        }

        // Jika pengguna ditemukan dan statusnya aktif, lanjutkan autentikasi
        if (Auth::attempt([
            $fieldType => $credentials['identifier'],
            'password' => $credentials['password']
        ])) {
            $request->session()->regenerate();
            return redirect()->intended(RouteServiceProvider::HOME);
        }

        return back()->withErrors([
            'identifier' => __('auth.failed'),
        ])->onlyInput('identifier');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        activity()
            ->causedBy(Auth::user())
            ->event('logout')
            ->log('User logged out');

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
