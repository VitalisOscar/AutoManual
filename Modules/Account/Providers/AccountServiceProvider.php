<?php

namespace Modules\Account\Providers;

use Config;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Database\Eloquent\Relations\Relation;
use Modules\Account\Models\User;

class AccountServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Relation::enforceMorphMap([
            User::MODEL_NAME => User::class
        ]);

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
            __DIR__ . '/../config/config.php' => config_path('account.php')
        ], 'config');

        $this->mergeConfigFrom(
            __DIR__ . '/../config/config.php', 'account'
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
        $langPath = resource_path('lang/modules/account');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'account');
        } else {
            $this->loadTranslationsFrom(__DIR__  .'/../resources/lang', 'account');
        }
    }

    private function registerViews(): void
    {
        $viewPath = resource_path('views/modules/account');

        $sourcePath = __DIR__ . '/../resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ], 'views');

        $this->loadViewsFrom(array_merge(array_map(static function ($path) {
            return "{$path}/modules/account";
        }, Config::get('view.paths')), [$sourcePath]), 'account');
    }
}
