<?php

namespace Iconic\Tests\Result;

use Iconic\Result\ResultException;
use Iconic\Result\Result;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class NullResultTest extends TestCase
{
    public function testNonSuccessfulStringResultWithExceptions(): void
    {
        $result = Result::ERROR('error');
        $exception = null;
        try {
            $val = $result->ensureValue();
        } catch (ResultException $e) {
            $exception = $e;
        }
        Assert::assertEquals('error', $result->getErrorMessage());
        Assert::assertFalse($result->wasSuccessful());
        Assert::assertTrue($result->wasNotSuccessful());
        Assert::assertTrue($exception instanceof ResultException);
        Assert::assertEquals('error', $exception->getMessage());
    }

    public function testNonSuccessfulStringResultWithoutExceptions(): void
    {
        $result = Result::ERROR('error');
        $exception = null;
        $val = null;
        try {
            if($result->wasSuccessful() && !$result->wasNotSuccessful()) {
                $val = $result->getValue();
            }
        } catch (ResultException $e) {
            $exception = $e;
        }
        Assert::assertEquals('error', $result->getErrorMessage());
        Assert::assertFalse($result->wasSuccessful());
        Assert::assertTrue($result->wasNotSuccessful());
        Assert::assertEquals(null, $exception);
        Assert::assertEquals(null, $val);
    }
}
