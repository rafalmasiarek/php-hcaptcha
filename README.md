# php-hcaptcha

A lightweight PHP library to validate hCaptcha response tokens using multiple HTTP request methods (e.g. cURL, Guzzle). Useful for environments with limited dependencies or custom HTTP clients.

## Features

- Supports cURL and Guzzle out of the box
- PSR-4 autoloading
- No external dependencies required by default (uses cURL)
- Works with PHP 8.0 or newer

## Installation

Install via Composer:

```bash
composer require rafalmasiarek/php-hcaptcha
```

## Usage

### Basic verification (default using cURL):

```php
use rafalmasiarek\hCaptcha\hCaptcha;

$captcha = new hCaptcha('your-hcaptcha-secret-key');

if ($captcha->verify($_POST['h-captcha-response'])) {
    // Valid token
} else {
    // Invalid token
    print_r($captcha->getLastErrorCodes());
}
```

### Using a custom request method (e.g., Guzzle):

```php
use rafalmasiarek\hCaptcha\hCaptcha;
use rafalmasiarek\hCaptcha\Request\GuzzleRequestMethod;

$captcha = new hCaptcha('your-secret', new GuzzleRequestMethod());

if ($captcha->verify($_POST['h-captcha-response'])) {
    // Success
}
```

## Testing

Run unit tests with PHPUnit:

```bash
vendor/bin/phpunit --bootstrap vendor/autoload.php tests
```

## Available Request Methods

- `CurlRequestMethod` (default, uses native PHP cURL)
- `GuzzleRequestMethod` (requires `guzzlehttp/guzzle`)

## License

MIT
