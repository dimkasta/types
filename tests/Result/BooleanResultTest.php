<?php

namespace Iconic\Tests\Result;

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
        Assert::assertNull($exception);
    }
}
