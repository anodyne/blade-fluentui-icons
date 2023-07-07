# Blade FluentUI Icons

<a href="https://github.com/anodyne/blade-fluentui-icons/actions?query=workflow%3ATests">
    <img src="https://github.com/blade-ui-kit/blade-heroicons/workflows/Tests/badge.svg" alt="Tests">
</a>
<a href="https://packagist.org/packages/anodyne/blade-fluentui-icons">
    <img src="https://img.shields.io/packagist/v/anodyne/blade-fluentui-icons" alt="Latest Stable Version">
</a>
<a href="https://packagist.org/packages/anodyne/blade-fluentui-icons">
    <img src="https://img.shields.io/packagist/dt/anodyne/blade-fluentui-icons" alt="Total Downloads">
</a>

A package to easily make use of [Fluent UI icons](https://github.com/microsoft/fluentui-system-icons) in your Laravel Blade views.

For a full list of available icons see [the SVG directory](resources/svg).

## Requirements

- PHP 8.1 or higher
- Laravel 9.0 or higher

## Installation

```bash
composer require anodyne/blade-fluentui-icons
```

## Blade Icons

Blade FluentUI icons uses Blade Icons under the hood. Please refer to [the Blade Icons readme](https://github.com/blade-ui-kit/blade-icons) for additional functionality. We also recommend to [enable icon caching](https://github.com/blade-ui-kit/blade-icons#caching) with this library.

## Configuration

Blade FluentUI icons also offers the ability to use features from Blade Icons like default classes, default attributes, etc. If you'd like to configure these, publish the `blade-fluentui-icons.php` config file:

```bash
php artisan vendor:publish --tag=blade-fluentui-icons-config
```

## Usage

Icons can be used as self-closing Blade components which will be compiled to SVG icons:

```blade
<x-fluentui-o-access-time/>
```

You can also pass classes to your icon components:

```blade
<x-fluentui-o-access-time class="w-6 h-6 text-gray-500"/>
```

And even use inline styles:

```blade
<x-fluentui-o-access-time style="color: #555"/>
```

The filled icons can be referenced like this:

```blade
<x-fluentui-f-access-time/>
```

### Raw SVG Icons

If you want to use the raw SVG icons as assets, you can publish them using:

```bash
php artisan vendor:publish --tag=blade-fluentui-icons --force
```

Then use them in your views like:

```blade
<img src="{{ asset('vendor/blade-fluentui-icons/f-access-time.svg') }}" width="10" height="10"/>
<img src="{{ asset('vendor/blade-fluentui-icons/o-access-time.svg') }}" width="10" height="10"/>
```

## Changelog

Check out the [CHANGELOG](CHANGELOG.md) in this repository for all the recent changes.

## Maintainers

Blade FluentUI icons is developed and maintained by Anodyne Productions.

## License

Blade FluentUI icons is open-sourced software licensed under [the MIT license](LICENSE.md).
