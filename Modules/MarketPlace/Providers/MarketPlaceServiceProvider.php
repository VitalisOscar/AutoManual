<?php

namespace Modules\MarketPlace\Providers;

use Config;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;

class MarketPlaceServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(EventServiceProvider::class);
    }

    public function provides(): array
    {
        return [];
    }

    private function registerConfig(): void
    {
        $this->publishes([
            __DIR__ . '/../config/config.php' => config_path('marketplace.php')
        ], 'config');

        $this->mergeConfigFrom(
            __DIR__ . '/../config/config.php', 'marketplace'
        );
    }

    private function registerFactories(): void
    {
        if (! $this->app->environment('production') && $this->app->runningInConsole()) {
            app(Factory::class)->load(__DIR__ . '/../database/factories');
        }
    }

    private function registerTranslations(): void
    {
        $langPath = resource_path('lang/modules/marketplace');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'marketplace');
        } else {
            $this->loadTranslationsFrom(__DIR__  .'/../resources/lang', 'marketplace');
        }
    }

    private function registerViews(): void
    {
        $viewPath = resource_path('views/modules/marketplace');

        $sourcePath = __DIR__ . '/../resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ], 'views');

        $this->loadViewsFrom(array_merge(array_map(static function ($path) {
            return "{$path}/modules/marketplace";
        }, Config::get('view.paths')), [$sourcePath]), 'marketplace');
    }
}
