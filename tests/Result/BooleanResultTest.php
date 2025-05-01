<?php

namespace Iconic\Tests\Result;

use Iconic\Assert\AssertError;
use Iconic\Result\ResultErrorMessage;
use Iconic\Result\ResultException;
use Iconic\Result\Result;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class BooleanResultTest extends TestCase
{
    public function testSuccessfulStringResult(): void
    {
        $result = Result::OK(true);
        $exception = null;
        try {
            Assert::assertTrue($result->ensureValue());
        } catch (ResultException $e) {
            $exception = $e;
        }
        Assert::assertEquals('', $result->getErrorMessage());
        Assert::assertTrue($result->wasSuccessful());
        Assert::assertFalse($result->wasNotSuccessful());
        Assert::assertTrue($result->getValue());
        Assert::assertTrue($result->getBoolean());
        Assert::assertNull($exception);
    }

    public function testBoolAssertion(): void
    {
        $this::expectException(AssertError::class);
        $this::expectExceptionMessage(ResultErrorMessage::BOOLEAN);
        $result = Result::OK('test');
        $result->getBoolean();
    }
}
