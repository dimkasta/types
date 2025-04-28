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
        $result = new Result(['123', '321']);
        $exception = null;
        try {
            /** @var array<mixed, mixed> $res */
            $res = $result->ensureValue();
            Assert::assertEquals('123', $res[0]);
            Assert::assertEquals('321', $res[1]);
        } catch (ResultException $e) {
            $exception = $e;
        }
        Assert::assertEquals('', $result->getMessage());
        Assert::assertTrue($result->wasSuccessful());
        /** @var array<mixed, mixed> $val */
        $val = $result->getValue();
        Assert::assertEquals('123', $val[0]);
        Assert::assertEquals('321', $val[1]);
        Assert::assertNull($exception);
    }

    public function testSuccessfulEmptyArrayResult(): void
    {
        $result = new Result([]);
        $exception = null;
        try {
            /** @var array<mixed, mixed> $res */
            $res = $result->ensureValue();
            Assert::assertEquals(0, count($res));
        } catch (ResultException $e) {
            $exception = $e;
        }
        Assert::assertEquals('', $result->getMessage());
        Assert::assertTrue($result->wasSuccessful());
        /** @var array<mixed, mixed> $val */
        $val = $result->getValue();
        Assert::assertEquals(0, count($val));
        Assert::assertNull($exception);
    }
}
