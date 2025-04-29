<?php

namespace Iconic\Tests\Result;

use Iconic\Result\ResultException;
use Iconic\Result\Result;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class IntResultTest extends TestCase
{
    public function testSuccessfulStringResult(): void
    {
        $result = Result::OK(123);
        $exception = null;
        try {
            Assert::assertEquals(123, $result->ensureValue());
        } catch (ResultException $e) {
            $exception = $e;
        }
        Assert::assertEquals('', $result->getErrorMessage());
        Assert::assertTrue($result->wasSuccessful());
        Assert::assertFalse($result->wasNotSuccessful());
        Assert::assertEquals(123, $result->getValue());
        Assert::assertNull($exception);
    }
}
