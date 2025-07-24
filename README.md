# php-hcaptcha

A lightweight PHP library to validate hCaptcha response tokens using multiple HTTP request methods (e.g. cURL, Guzzle). Useful for environments with limited dependencies or custom HTTP clients.

### Disclaimer about the Origins of This Project

In 2020, I discovered that Cloudflare had stopped using reCAPTCHA in favor of another solution — hCaptcha. I’ve started using it too, hoping that they collect less data about us than Google does. Cloudflare even wrote an article about the change:  
[*"Moving from reCAPTCHA to hCaptcha"*](https://blog.cloudflare.com/moving-from-recaptcha-to-hcaptcha/)

As of 2025, Cloudflare still uses hCaptcha, but mainly as part of its **Managed Challenge** system. In recent years, Cloudflare has also developed and begun rolling out its own CAPTCHA alternative called **Turnstile**, which is invisible to users and focused on privacy and usability. While hCaptcha remains in use as a fallback, Turnstile is now the default solution for many scenarios.

For more information on this transition:

- [Cloudflare Blog — "End Cloudflare CAPTCHA"](https://blog.cloudflare.com/end-cloudflare-captcha/)

- [Cloudflare Turnstile Migration Guide](https://developers.cloudflare.com/turnstile/migration/hcaptcha/)

---

## hCaptcha vs reCAPTCHA — Pros and Cons

### hCaptcha

**Pros:**

- **More privacy-friendly**: Operated by a smaller company (Intuition Machines), hCaptcha claims to collect less personal data compared to Google’s reCAPTCHA.

- **Revenue opportunity**: Websites can earn small amounts of money for solving CAPTCHAs, which can offset server or security costs.

- **Focus on accessibility and GDPR compliance**: Designed to align better with data protection regulations, especially in Europe.

**Cons:**

- **Slightly harder challenges**: Some users find hCaptcha more difficult or annoying than reCAPTCHA.

- **Less widespread compatibility**: Not as universally integrated as reCAPTCHA, which may cause issues in edge cases.

---

### reCAPTCHA

**Pros:**

- **Extremely accurate and battle-tested**: Google’s AI-powered system is highly effective at blocking bots.

- **Better user experience (in v3)**: reCAPTCHA v3 is invisible to users and runs in the background, reducing friction.

**Cons:**

- **Privacy concerns**: As a Google product, it may collect and share user data across its ecosystem.

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
