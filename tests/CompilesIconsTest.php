<?php

declare(strict_types=1);

use BladeUI\Icons\Exceptions\SvgNotFound;
use Illuminate\Support\Facades\Blade;

it('renders the filled icon contents', function () {
    $expected = <<<'SVG'
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20"><path fill="currentColor" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16M6.988 8.608a.5.5 0 0 1-.977-.211v-.005a2 2 0 0 1 .32-.687A1.7 1.7 0 0 1 7.756 7c.552 0 1.001.215 1.308.561.298.337.438.772.438 1.189 0 .349-.069.648-.205.906a1.8 1.8 0 0 1-.507.585 5 5 0 0 1-.48.313l-.056.034c-.168.1-.306.187-.425.29-.394.341-.652.702-.764 1.122H9a.5.5 0 0 1 0 1H6.5a.5.5 0 0 1-.5-.5c0-1.01.475-1.774 1.173-2.378.19-.166.396-.29.567-.393l.058-.035a4 4 0 0 0 .379-.244.8.8 0 0 0 .233-.26.9.9 0 0 0 .09-.44.8.8 0 0 0-.187-.526C8.203 8.1 8.03 8 7.753 8c-.33 0-.505.146-.614.295a1 1 0 0 0-.147.3zM11 7a.5.5 0 0 1 .5.5V10H13V7.5a.5.5 0 0 1 1 0v5a.5.5 0 0 1-1 0V11h-2a.5.5 0 0 1-.5-.5v-3A.5.5 0 0 1 11 7"/></svg>
    SVG;

    expect(svg('fluent-f-access-time')->toHtml())->toBe($expected);
});

it('renders both icon variants', function (string $variant) {
    expect(svg("fluent-{$variant}-access-time")->toHtml())
        ->toBe(trim(file_get_contents(__DIR__."/../resources/svg/{$variant}-access-time.svg")));
})->with(['f', 'o']);

it('adds classes and attributes to icons', function () {
    expect(svg('fluent-f-access-time', 'w-6 h-6', ['aria-label' => 'Clock'])->toHtml())
        ->toContain('class="w-6 h-6"', 'aria-label="Clock"');
});

it('accepts an attribute array as the second argument', function () {
    expect(svg('fluent-f-access-time', ['style' => 'color: #555'])->toHtml())
        ->toContain('style="color: #555"');
});

it('renders Blade components with attributes', function (string $variant) {
    $result = Blade::render('<x-fluent-'.$variant.'-access-time class="w-6" aria-label="Clock" />');

    expect($result)->toContain('<svg', 'class="w-6"', 'aria-label="Clock"', '<path');
})->with(['f', 'o']);

it('renders the Blade svg directive', function () {
    expect(trim(Blade::render("@svg('fluent-f-access-time')")))
        ->toBe(svg('fluent-f-access-time')->toHtml());
});

it('throws for a missing icon without a fallback', function () {
    svg('fluent-missing-icon');
})->throws(SvgNotFound::class);
