<?php

namespace App\Livewire\Admin\Auth;

use App\Exceptions\TooManyRequestException;
use App\Traits\Livewire\WithRateLimitingLivewire;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Spatie\Honeypot\Http\Livewire\Concerns\HoneypotData;
use Spatie\Honeypot\Http\Livewire\Concerns\UsesSpamProtection;

class PasswordForgetForm extends Component
{
    use AuthorizesRequests,
        UsesSpamProtection,
        WithRateLimitingLivewire;

    public ?string $email;
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
     * Password attempt
     * @return mixed
     */
    public function passwordAttempt(): mixed
    { // Rate limiter
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
                'email' => 'required|email',
            ],
            [
                'email.required' => __('admin.auth.username_required'),
                'email.required' => __('admin.auth.username_required'),
            ],
        );
        return true;
    }

    /**
     * Render the component
     * @return View
     */
    public function render(): View
    {
        return view('livewire.admin.auth.password-forget-form');
    }
}
