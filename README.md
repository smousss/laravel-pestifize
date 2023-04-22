![Pestifize](https://user-images.githubusercontent.com/3613731/233783272-13140966-f41c-414d-9193-91d4c6e0d9e2.png)

# Convert all your tests from PHPUnit to Pest 2

[![Latest Version on Packagist](https://img.shields.io/packagist/v/smousss/laravel-pestifize.svg?style=flat-square)](https://packagist.org/packages/smousss/laravel-pestifize)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/smousss/laravel-pestifize/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/smousss/laravel-pestifize/actions?query=workflow%3Arun-tests+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/smousss/laravel-pestifize.svg?style=flat-square)](https://packagist.org/packages/smousss/laravel-pestifize)

Smousss converts every PHPUnit test you have to Pest 2. In other words, it makes your tests more readable, maintainable and less verbose in a matter of seconds.

## Installation

Install the package via Composer:

```bash
composer require smousss/laravel-pestifize --dev
```

Publish the config file:

```bash
php artisan vendor:publish --tag=pestifize-config
```

## Usage

First, [generate a secret key](https://smousss.com/dashboard) on smousss.com.

Then, start migrating your PHPUnit tests to Pest 2:

```php
php artisan smousss:pestifize
```

## Credit

Pestifize for Laravel has been developed by [Benjamin Crozat](https://benjamincrozat.com) for [Smousss](https://smousss.com) ([Twitter](https://twitter.com/benjamincrozat)).

## License

[MIT](LICENSE.md)
