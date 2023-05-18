<?php

declare(strict_types=1);

namespace Anodyne\FluentUiIcons;

use BladeUI\Icons\Factory;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;

final class BladeFluentUiIconsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerConfig();

        $this->callAfterResolving(Factory::class, function (Factory $factory, Container $container) {
            $config = $container->make('config')->get('blade-fluentui-icons', []);

            $factory->add('fluent-ui', array_merge([
                'path' => __DIR__.'/../resources/svg',
                'prefix' => 'fluent'
            ], $config));
        });
    }

    private function registerConfig(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/blade-fluentui-icons.php', 'blade-fluentui-icons');
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../resources/svg' => public_path('vendor/blade-fluentui-icons'),
            ], 'blade-fluentui-icons');

            $this->publishes([
                __DIR__.'/../config/blade-fluentui-icons.php' => $this->app->configPath('blade-fluentui-icons.php'),
            ], 'blade-fluentui-icons-config');
        }
    }
}
