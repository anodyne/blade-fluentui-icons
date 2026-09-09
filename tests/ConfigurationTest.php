<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;
use Tests\ConfiguredTestCase;

uses(ConfiguredTestCase::class);

it('uses the configured prefix for helpers and Blade components', function () {
    expect(svg('custom-f-access-time')->toHtml())->toContain('<svg', '<path');
    expect(Blade::render('<x-custom-o-access-time />'))->toContain('<svg', '<path');
});

it('merges default classes with per-icon classes', function () {
    expect(svg('custom-f-access-time', 'w-6')->toHtml())
        ->toContain('class="default-icon w-6"');
});

it('applies default attributes and permits per-icon overrides', function () {
    expect(svg('custom-f-access-time')->toHtml())
        ->toContain('width="24"', 'aria-hidden="true"');
    expect(svg('custom-f-access-time', '', ['width' => 32])->toHtml())
        ->toContain('width="32"', 'aria-hidden="true"')
        ->not->toContain('width="24"');
});

it('renders the configured fallback for a missing icon', function () {
    expect(svg('custom-missing-icon')->toHtml())
        ->toBe(svg('custom-o-access-time')->toHtml());
});
