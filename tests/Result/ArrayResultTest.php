<?php

namespace Iconic\Tests\Result;

use Iconic\Result\Result;
use Iconic\Result\ResultException;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class ArrayResultTest extends TestCase
{
    public function testSuccessfulStringResult(): void
    {
        $result = Result::OK(['123', '321']);
        $exception = null;
        try {
            /** @var array<mixed, mixed> $res */
            $res = $result->ensureValue();
            Assert::assertEquals('123', $res[0]);
            Assert::assertEquals('321', $res[1]);
        } catch (ResultException $e) {
            $exception = $e;
        }
        Assert::assertEquals('', $result->getErrorMessage());
        Assert::assertTrue($result->wasSuccessful());
        Assert::assertFalse($result->wasNotSuccessful());
        /** @var array<mixed, mixed> $val */
        $val = $result->getValue();
        Assert::assertEquals('123', $val[0]);
        Assert::assertEquals('321', $val[1]);
        Assert::assertNull($exception);
    }

    public function testSuccessfulEmptyArrayResult(): void
    {
        $result = Result::OK([]);
        $exception = null;
        try {
            /** @var array<mixed, mixed> $res */
            $res = $result->ensureValue();
            Assert::assertEquals(0, count($res));
        } catch (ResultException $e) {
            $exception = $e;
        }
        Assert::assertEquals('', $result->getErrorMessage());
        Assert::assertTrue($result->wasSuccessful());
        Assert::assertFalse($result->wasNotSuccessful());
        /** @var array<mixed, mixed> $val */
        $val = $result->getValue();
        Assert::assertEquals(0, count($val));
        Assert::assertNull($exception);
    }
}
