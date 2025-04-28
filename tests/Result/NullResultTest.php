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
        $result = new Result(null, 'error');
        $exception = null;
        try {
            $val = $result->ensureValue();
        } catch (ResultException $e) {
            $exception = $e;
        }
        Assert::assertEquals('error', $result->getMessage());
        Assert::assertFalse($result->wasSuccessful());
        Assert::assertTrue($exception instanceof ResultException);
        Assert::assertEquals('error', $exception->getMessage());
    }

    public function testNonSuccessfulStringResultWithoutExceptions(): void
    {
        $result = new Result(null, 'error');
        $exception = null;
        $val = null;
        try {
            if($result->wasSuccessful()) {
                $val = $result->getValue();
            }
        } catch (ResultException $e) {
            $exception = $e;
        }
        Assert::assertEquals('error', $result->getMessage());
        Assert::assertFalse($result->wasSuccessful());
        Assert::assertEquals(null, $exception);
        Assert::assertEquals(null, $val);
    }
}
