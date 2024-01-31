<?php

namespace App\Providers;

use App\Models\Settings\Language;
use App\Models\Settings\Url;
use App\Observers\Settings\LanguageObserver;
use App\Observers\Settings\UrlObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        $this->registerObservers();
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }

    /**
     * Register the observers
     */
    protected function registerObservers(): void
    {
        Language::observe(LanguageObserver::class);
        Url::observe(UrlObserver::class);
    }
}
