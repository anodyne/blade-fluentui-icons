<?php

declare(strict_types=1);

use Anodyne\FluentUiIcons\BladeFluentUiIconsServiceProvider;
use Illuminate\Config\Repository;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

it('loads the default configuration', function () {
    expect(config('blade-fluentui-icons'))
        ->toBe(require __DIR__.'/../config/blade-fluentui-icons.php');
});

it('registers publishable icons and configuration', function () {
    $icons = ServiceProvider::pathsToPublish(BladeFluentUiIconsServiceProvider::class, 'blade-fluentui-icons');
    $config = ServiceProvider::pathsToPublish(BladeFluentUiIconsServiceProvider::class, 'blade-fluentui-icons-config');

    expect(array_values($icons))->toBe([public_path('vendor/blade-fluentui-icons')]);
    expect(realpath(array_key_first($icons)))->toBe(realpath(__DIR__.'/../resources/svg'));
    expect(array_values($config))->toBe([config_path('blade-fluentui-icons.php')]);
    expect(realpath(array_key_first($config)))->toBe(realpath(__DIR__.'/../config/blade-fluentui-icons.php'));
});

it('preserves partial configuration overrides while merging defaults', function () {
    $app = new Application(__DIR__.'/..');
    $app->instance('config', new Repository([
        'blade-fluentui-icons' => ['prefix' => 'custom'],
    ]));

    (new BladeFluentUiIconsServiceProvider($app))->register();

    expect($app['config']->get('blade-fluentui-icons'))->toBe(array_merge(
        require __DIR__.'/../config/blade-fluentui-icons.php',
        ['prefix' => 'custom'],
    ));
});
