# hCaptcha PHP Client
## PHP hCaptcha Component Library

I accidentally discovered that Cloudflare stop using reCaptch in favor of another `hCaptcha` solution, which I started using this too with hope they collect less data about us than Google does
Cloudflare wrote an article about it : [Moving from reCAPTCHA to hCaptcha](https://blog.cloudflare.com/moving-from-recaptcha-to-hcaptcha/)

Basic usage on backend validator:

```php
<?php

$privToken = '';
$hcaptcha = new rafalmasiarek\hCaptcha($privToken);
$verify   = $hcaptcha->verify($_POST['h-captcha-response'])
if( $verify['success'] == true) {
    echo "Legit request!";
}
```
