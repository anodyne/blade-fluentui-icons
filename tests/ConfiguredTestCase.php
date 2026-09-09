<?php

declare(strict_types=1);

namespace Tests;

abstract class ConfiguredTestCase extends TestCase
{
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('blade-fluentui-icons', [
            'prefix' => 'custom',
            'class' => 'default-icon',
            'attributes' => ['width' => 24, 'aria-hidden' => 'true'],
            'fallback' => 'o-access-time',
        ]);
    }
}
