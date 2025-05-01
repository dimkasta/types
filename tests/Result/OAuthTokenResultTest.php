<?php

namespace Iconic\Tests\Result;

use Carbon\Carbon;
use Iconic\Assert\AssertError;
use Iconic\Result\ResultErrorMessage;
use Iconic\Result\ResultException;
use Iconic\Result\Result;
use Iconic\Type\OAuthToken;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class OAuthTokenResultTest extends TestCase
{
    public function testSuccessfulStringResult(): void
    {
        $result = Result::OK(new OAuthToken('123', Carbon::today()->addDay()));
        $exception = null;
        try {
            /** @var OAuthToken $ensured */
            $ensured = $result->ensureValue();
            Assert::assertEquals('123', $ensured->getToken());
        } catch (ResultException $e) {
            $exception = $e;
        }
        Assert::assertEquals('', $result->getErrorMessage());
        Assert::assertTrue($result->wasSuccessful());
        Assert::assertFalse($result->wasNotSuccessful());
        /** @var OAuthToken $res */
        $res = $result->getValue();
        Assert::assertEquals('123', $res->getToken());
        Assert::assertEquals('123', $result->getOAuthToken()->getToken());
        Assert::assertNull($exception);
    }

    public function testOAuthTokenAssertion(): void
    {
        $this::expectException(AssertError::class);
        $this::expectExceptionMessage(ResultErrorMessage::OAUTHTOKEN);
        $result = Result::OK('test');
        $result->getOAuthToken();
    }
}
