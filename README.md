# Interact with the Cutt.ly API via Laravels Http Helper

[![Latest Version on Packagist](https://img.shields.io/packagist/v/b-ramin/cuttlyphp.svg?style=flat-square)](https://packagist.org/packages/b-ramin/cuttlyphp)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/b-ramin/cuttlyphp/Check%20&%20fix%20styling?label=code%20style)](https://github.com/b-ramin/cuttlyphp/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/b-ramin/cuttlyphp.svg?style=flat-square)](https://packagist.org/packages/b-ramin/cuttlyphp)

Cutt.ly is a URL shortening service. This package uses Laravel's Http helper to interact with that service to create, update and delete shortened links.

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
    'user_domain' => '0',
    'no_title' => '1',
    'public' => '1',
];
```

Make sure to se the _key_ to your key from Cutt.ly

## Usage

###Initialize the class:
```php
$cuttly = new Bramin\CuttlyPHP();
```

###Test to make sure the endpoint is working:
```php
echo $cuttly->ping();
```

###Create a new short link:
```php
$details = $cuttlyPHP->create('https://google.com', '', false, true, true);
```
* The first parameter should contain the URL to be shortened (required). 
* The second parameter is for the name of the url. This is the first and only uri segment after the domain name. Passing null or an empty array will generate a random and unique string.
* The third parameter is for whether it should use the custom domain name. This defaults to false.
* The fourth parameter disables the title lookup to improve speed.
* The fifth and last parameter controls whether the link is public or private.

###Delete a short link:
```php
$cuttlyPHP->delete('https://cutt.ly/123abc');
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
