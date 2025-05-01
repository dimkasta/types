<?php

namespace Iconic\Tests\Result;

use Brick\Money\Money;
use Iconic\Assert\AssertError;
use Iconic\Result\ResultErrorMessage;
use Iconic\Result\ResultException;
use Iconic\Result\Result;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class MoneyResultTest extends TestCase
{
    public function testSuccessfulStringResult(): void
    {
        $result = Result::OK(Money::of(100, 'EUR'));
        $exception = null;
        try {
            /** @var Money $ensured */
            $ensured = $result->ensureValue();
            Assert::assertEquals(Money::of(100, 'EUR')->getAmount(), $ensured->getAmount());
        } catch (ResultException $e) {
            $exception = $e;
        }
        Assert::assertEquals('', $result->getErrorMessage());
        Assert::assertTrue($result->wasSuccessful());
        Assert::assertFalse($result->wasNotSuccessful());
        /** @var Money $res */
        $res = $result->getValue();
        Assert::assertEquals(Money::of(100, 'EUR')->getAmount(), $res->getAmount());
        Assert::assertEquals(Money::of(100, 'EUR')->getAmount(), $result->getMoney()->getAmount());
        Assert::assertNull($exception);
    }

    public function testMoneyAssertion(): void
    {
        $this::expectException(AssertError::class);
        $this::expectExceptionMessage(ResultErrorMessage::MONEY);
        $result = Result::OK('test');
        $result->getMoney();
    }
}
