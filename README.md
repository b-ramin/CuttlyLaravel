# Interact with the Cutt.ly API via Laravels Http Helper

[![Latest Version on Packagist](https://img.shields.io/packagist/v/bramin/cuttlylaravel.svg?style)](https://packagist.org/packages/bramin/cuttlylaravel)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/b-ramin/cuttlylaravel/Check%20&%20fix%20styling?label=code%20style)](https://github.com/b-ramin/cuttlylaravel/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/bramin/cuttlylaravel.svg?style)](https://packagist.org/packages/bramin/cuttlylaravel)

Cutt.ly is a URL shortening service. This package uses Laravel's Http helper to interact with that service to create, update and delete shortened links.

## Installation

You can install the package via composer:

```bash
composer require bramin/cuttlylaravel
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="cuttly-laravel-config"
```

This is the contents of the published config file:

```php
return [
    'key' => '',
    'user_domain' => '0',
    'no_title' => '1',
    'public' => '1',
];
```

Make sure to set the _key_ to your key from Cutt.ly

## Usage

### Include the Cuttly Facade
```php
use Bramin\CuttlyPHP\Facades\Cuttly;
```

### Test the api status
```php
$success = Cuttly::ping();
```

### Create a new link:
```php
$details = Cuttly::create('https://google.com', '', false, true, true);
```
#### Parameters:
* `short`: The URL to be shortened (required)
* `name`: The first and only uri segment after the domain name. Passing null or an empty array will generate a random and unique string.
* `userDomain`: whether it should use the custom domain name instead of cutt.ly. Defaults to `false`.
* `noTitle`: Disables the title lookup to improve speed. Defaults to `true`.
* `public`: Whether the link is public or private. Defaults to `true`.

### Link analytics:
```php
$success = Cuttly::getAnalytics('https://cutt.ly/abcd', '2022-04-01', '2022-05-01');
```
#### Parameters:
* `short`: The URL to be shortened (required)
* `dateFrom`: Sets the start date of the period to return data for. Format: `YYYY-MM-DD`, e.g. `2021-03-02`
* `dateTo`: Sets the end date of the period to return data for. Format: `YYYY-MM-DD`, e.g. `2021-03-02`

### Add a tag to a link:
```php
$success = Cuttly::addTag('https://cutt.ly/abcd', 'tagname');
```
### Update the source of a link:
```php
$success = Cuttly::updateSource('https://cutt.ly/abcd', 'http://www.google.com');
```

### Update the title of a link:
```php
$success = Cuttly::updateTitle('https://cutt.ly/abcd', 'Google Home Page');
```

### Delete a link:
```php
$success = Cuttly::delete('https://cutt.ly/abcd');
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
