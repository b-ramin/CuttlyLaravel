# Interact with the Cutt.ly API via Laravels Http Helper

[![Latest Version on Packagist](https://img.shields.io/packagist/v/b-ramin/cuttlyphp.svg?style=flat-square)](https://packagist.org/packages/b-ramin/cuttlyphp)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/b-ramin/cuttlyphp/run-tests?label=tests)](https://github.com/b-ramin/cuttlyphp/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/b-ramin/cuttlyphp/Check%20&%20fix%20styling?label=code%20style)](https://github.com/b-ramin/cuttlyphp/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/b-ramin/cuttlyphp.svg?style=flat-square)](https://packagist.org/packages/b-ramin/cuttlyphp)

Cutt.ly is a url shortening service. This package uses Laravel's Http helper to interact with that service to create or delete shortened links.

## Installation

You can install the package via composer:

```bash
composer require b-ramin/cuttlyphp
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="cuttlyphp-config"
```

This is the contents of the published config file:

```php
return [
    'key' => '',
    'custom_domain' => '',
];
```

## Usage

```php
$cuttlyPHP = new Bramin\CuttlyPHP();
echo $cuttlyPHP->ping();
```

```php
echo $cuttlyPHP->createShortLink('https://google.com');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/spatie/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Brett Ramin](https://github.com/b-ramin)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
