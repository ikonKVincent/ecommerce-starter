<?php

namespace App\Livewire\Admin\Auth;

use App\Exceptions\TooManyRequestException;
use App\Traits\Livewire\WithRateLimitingLivewire;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Spatie\Honeypot\Http\Livewire\Concerns\HoneypotData;
use Spatie\Honeypot\Http\Livewire\Concerns\UsesSpamProtection;

class LoginForm extends Component
{
    use AuthorizesRequests,
        UsesSpamProtection,
        WithRateLimitingLivewire;

    public ?string $password;
    public ?string $username;
    public HoneypotData $extraFields;

    /**
     * Mount the component
     * @return void
     */
    public function mount(): void
    {
        $this->extraFields = new HoneypotData();
    }

    /**
     * Login attempt
     * @return mixed
     */
    public function authAttempt(): mixed
    {
        // Rate limiter
        try {
            $this->rateLimit(5, 180);
        } catch (TooManyRequestException $exception) {
            $secondsUntilAvailable = $exception->secondsUntilAvailable;
            $minutesUntilAvailable = ceil($secondsUntilAvailable / 60);
            throw ValidationException::withMessages([
                'rate_limiter' => __('exceptions.rate_limiter', ['minutes' => $minutesUntilAvailable, 'seconds' => $secondsUntilAvailable]),
            ]);
        }
        // Validate
        $this->protectAgainstSpam();
        $this->validate(
            [
                'username' => 'required|string',
                'password' => 'required',
            ],
            [
                'username.required' => __('admin.auth.username_required'),
                'password.required' => __('admin.auth.password_required'),
            ],
        );
        // Auth
        $authCheck = Auth::guard('admin')->attempt([
            'email' => $this->username,
            'password' => $this->password,
        ], false);
        // Auth Success
        if ($authCheck) {
            session()->flash('success', __('admin.auth.auth_success', ['name' => Auth::guard('admin')->user()->displayName()]));

            return redirect()->intended(route('admin.dashboard'));
        }
        // Auth Error
        session()->flash('error', __('admin.auth.auth_error'));

        return false;
    }

    /**
     * Render the component
     * @return View
     */
    public function render(): View
    {
        return view('livewire.admin.auth.login-form');
    }
}
