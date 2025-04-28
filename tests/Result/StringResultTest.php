<?php

namespace Iconic\Tests\Result;

use Iconic\Result\ResultException;
use Iconic\Result\Result;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class StringResultTest extends TestCase
{
    public function testSuccessfulStringResult(): void
    {
        $result = new Result('123');
        $exception = null;
        try {
            Assert::assertEquals('123', $result->ensureValue());
        } catch (ResultException $e) {
            $exception = $e;
        }
        Assert::assertEquals('', $result->getMessage());
        Assert::assertTrue($result->wasSuccessful());
        Assert::assertEquals('123', $result->getValue());
        Assert::assertNull($exception);
    }
}
