<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Login form page
     * @return View|RedirectResponse
     */
    public function login(): View|RedirectResponse
    {
        // Auth check
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login', [
            'seo_title' => null,
            'seo_description' => null,
            'seo_robot' => false,
        ]);
    }

    /**
     * Logout admin
     * @return RedirectResponse
     */
    public function logout(): RedirectResponse
    {
        Auth::guard('admin')->logout();
        session()->flash('success', __('admin.auth.logout_success'));

        return redirect()->route('admin.login');
    }

    /**
     * Password page
     * @return View|RedirectResponse
     */
    public function password(): View|RedirectResponse
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('dashboard');
        }
        return view('admin.auth.password', [
            'seo_title' => __('admin.auth.forgot_password'),
            'seo_description' => null,
            'seo_robot' => false,
        ]);
    }
}
