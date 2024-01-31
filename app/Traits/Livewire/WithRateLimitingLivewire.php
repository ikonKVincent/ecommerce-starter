<?php

namespace App\Traits\Livewire;

use App\Exceptions\TooManyRequestException;
use Illuminate\Support\Facades\RateLimiter;

trait WithRateLimitingLivewire
{
    protected function clearRateLimiter($method = null): void
    {
        if (!$method) {
            $method = debug_backtrace()[1]['function'];
        }

        $key = $this->getRateLimitKey($method);

        RateLimiter::clear($key);
    }

    protected function getRateLimitKey($method)
    {
        if (!$method) {
            $method = debug_backtrace()[1]['function'];
        }

        return sha1(static::class . '|' . $method . '|' . request()->ip());
    }

    protected function hitRateLimiter($method = null, $decaySeconds = 60): void
    {
        if (!$method) {
            $method = debug_backtrace()[1]['function'];
        }

        $key = $this->getRateLimitKey($method);

        RateLimiter::hit($key, $decaySeconds);
    }

    protected function rateLimit($maxAttempts, $decaySeconds = 60, $method = null): void
    {
        if (!$method) {
            $method = debug_backtrace()[1]['function'];
        }

        $key = $this->getRateLimitKey($method);

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $component = static::class;
            $ip = request()->ip();
            $secondsUntilAvailable = RateLimiter::availableIn($key);

            throw new TooManyRequestException($component, $method, $ip, $secondsUntilAvailable);
        }

        $this->hitRateLimiter($method, $decaySeconds);
    }
}
