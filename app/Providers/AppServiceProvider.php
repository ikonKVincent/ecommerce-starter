<?php

namespace App\Providers;

use App\Base\AttributeManifest;
use App\Base\AttributeManifestInterface;
use App\Base\FieldTypeManifest;
use App\Base\FieldTypeManifestInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Carbon::setLocale('fr');
        setlocale(LC_TIME, 'fr_FR.UTF8', 'fr.UTF8', 'fr_FR.UTF-8', 'fr.UTF-8');

        $this->app->singleton(AttributeManifestInterface::class, function ($app) {
            return $app->make(AttributeManifest::class);
        });

        $this->app->singleton(FieldTypeManifestInterface::class, function ($app) {
            return $app->make(FieldTypeManifest::class);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::preventLazyLoading(!app()->isProduction());
        $this->registerAuthGuard();
        $this->registerMacros();
        // Handle generator
        Str::macro('handle', function ($string) {
            return Str::slug($string, '_');
        });
    }

    /**
     * Register admin auth guard.
     */
    protected function registerAuthGuard(): void
    {
        $this->app['config']->set('auth.providers.admin', [
            'driver' => 'eloquent',
            'model' => \App\Models\Admins\Admin::class,
        ]);

        $this->app['config']->set('auth.guards.admin', [
            'driver' => 'session',
            'provider' => 'admin',
        ]);
    }
    /**
     * Register the blueprint macros.
     */
    protected function registerMacros(): void
    {
        Blueprint::macro('publishedFields', function (): void {
            /** @var Blueprint $this */
            $this->boolean('is_published')->default(0);
            $this->timestamp('published_at')->nullable();
        });

        Blueprint::macro('scheduling', function () {
            /** @var Blueprint $this */
            $this->boolean('enabled')->default(false)->index();
            $this->timestamp('started_at')->nullable()->index();
            $this->timestamp('ended_at')->nullable()->index();
        });

        Blueprint::macro('dimensions', function (): void {
            /** @var Blueprint $this */
            $columns = ['length', 'width', 'height', 'weight', 'volume'];
            foreach ($columns as $column) {
                $this->decimal("{$column}_value", 10, 4)->default(0)->nullable()->index();
                $this->string("{$column}_unit")->default('mm')->nullable();
            }
        });
    }
}
