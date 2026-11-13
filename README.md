# hCaptcha PHP Client
## PHP hCaptcha Component Library

### **THIS REPOSITORY IS NO LONGER MAINTAINED**

*This repository has been abandoned in favor of [php-captcha](https://github.com/rafalmasiarek/php-captcha), a more comprehensive CAPTCHA solution.*

All further development and maintenance will take place in the new repository. Please use [php-captcha](https://github.com/rafalmasiarek/php-captcha) for the latest version and future updates.

I accidentally discovered that Cloudflare has stopped using reCAPTCHA in favor of another solution, hCaptcha. I’ve started using it too, hoping that it collects less data about us than Google does.

Cloudflare wrote an article about this transition: [Moving from reCAPTCHA to hCaptcha](https://blog.cloudflare.com/moving-from-recaptcha-to-hcaptcha/).

Basic usage in a backend validator:

```php
<?php

$privToken = '';
$hcaptcha = new rafalmasiarek\hCaptcha($privToken);
$verify = $hcaptcha->verify($_POST['h-captcha-response']);

if ($verify['success'] === true) {
    echo "Legit request!";
}
