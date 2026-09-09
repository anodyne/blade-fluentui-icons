<?php

declare(strict_types=1);

use Anodyne\FluentUiIcons\FluentUI;
use Tests\TestCase;

uses(TestCase::class);

it('maps every bundled icon to exactly one enum case', function () {
    $expected = array_map(
        fn (string $file) => 'fluent-'.basename($file, '.svg'),
        glob(__DIR__.'/../resources/svg/*.svg'),
    );
    sort($expected);

    $actual = array_map(fn (FluentUI $icon) => $icon->value, FluentUI::cases());
    sort($actual);

    expect($actual)->not->toBeEmpty()->toBe($expected);
});

it('uses plain outline names and the Filled suffix for filled icons', function () {
    foreach (FluentUI::cases() as $icon) {
        $name = str_replace(' ', '', ucwords(str_replace('-', ' ', substr($icon->value, 9))));

        if (str_starts_with($icon->value, 'fluent-f-')) {
            $name .= 'Filled';
        }

        if (ctype_digit($name[0]) || strtolower($name) === 'class') {
            $name = 'Icon'.$name;
        }

        expect($icon->name)->toBe($name);
    }
});

it('renders icons referenced by the enum', function (FluentUI $icon, string $filename) {
    expect(svg($icon->value)->toHtml())
        ->toBe(trim(file_get_contents(__DIR__.'/../resources/svg/'.$filename.'.svg')));
})->with([
    'filled' => [FluentUI::AccessTimeFilled, 'f-access-time'],
    'outline' => [FluentUI::AccessTime, 'o-access-time'],
    'numeric name' => [FluentUI::Battery0Filled, 'f-battery-0'],
]);
