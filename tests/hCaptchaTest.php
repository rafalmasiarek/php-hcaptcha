<?php

use PHPUnit\Framework\TestCase;
use rafalmasiarek\hCaptcha\hCaptcha;
use rafalmasiarek\hCaptcha\Request\RequestMethodInterface;

class hCaptchaTest extends TestCase
{
    public function testVerifyReturnsTrueOnSuccess()
    {
        $mock = $this->createMock(RequestMethodInterface::class);
        $mock->method('submit')->willReturn(['success' => true]);

        $captcha = new hCaptcha('dummy-secret', $mock);
        $result = $captcha->verify('dummy-response');

        $this->assertTrue($result);
        $this->assertEmpty($captcha->getLastErrorCodes());
    }

    public function testVerifyReturnsFalseOnEmptyToken()
    {
        $captcha = new hCaptcha('dummy-secret');
        $result = $captcha->verify('');

        $this->assertFalse($result);
        $this->assertContains('empty-response', $captcha->getLastErrorCodes());
    }

    public function testVerifyReturnsFalseOnFailureResponse()
    {
        $mock = $this->createMock(RequestMethodInterface::class);
        $mock->method('submit')->willReturn(['success' => false, 'error-codes' => ['invalid-input-response']]);

        $captcha = new hCaptcha('dummy-secret', $mock);
        $result = $captcha->verify('invalid-response');

        $this->assertFalse($result);
        $this->assertContains('invalid-input-response', $captcha->getLastErrorCodes());
    }
}
