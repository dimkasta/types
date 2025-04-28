<?php

namespace Iconic\Tests\Result;

use Brick\Money\Money;
use Iconic\Result\ResultException;
use Iconic\Result\Result;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class MoneyResultTest extends TestCase
{
    public function testSuccessfulStringResult(): void
    {
        $result = new Result(Money::of(100, 'EUR'));
        $exception = null;
        try {
            /** @var Money $ensured */
            $ensured = $result->ensureValue();
            Assert::assertEquals(Money::of(100, 'EUR')->getAmount(), $ensured->getAmount());
        } catch (ResultException $e) {
            $exception = $e;
        }
        Assert::assertEquals('', $result->getMessage());
        Assert::assertTrue($result->wasSuccessful());
        /** @var Money $res */
        $res = $result->getValue();
        Assert::assertEquals(Money::of(100, 'EUR')->getAmount(), $res->getAmount());
        Assert::assertNull($exception);
    }
}
