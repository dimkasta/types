<?php

namespace Iconic\Result;

use Brick\Money\Money;
use Iconic\Assert\Assert;
use Iconic\Type\OAuthToken;

readonly class Result
{
    /**
     * @var string|int|OAuthToken|Money|bool|array<mixed,mixed>
     */
    private string|int|OAuthToken|Money|bool|array $nonNullValue;
    /**
     * @var string|int|OAuthToken|Money|bool|array<mixed,mixed>|null
     */
    private null|string|int|OAuthToken|Money|bool|array $value;
    private string $errorMessage;

    /**
     * @param string|int|OAuthToken|Money|bool|array<mixed,mixed>|null $value
     * @param string $errorMessage
     */
    private function __construct(
        null|string|int|OAuthToken|Money|bool|array $value,
        string                                      $errorMessage = '',
    )
    {
        $this->errorMessage = $errorMessage;
        $this->value = $value;
        if (!is_null($value)) {
            $this->nonNullValue = $value;
        } else {
            $this->nonNullValue = '';
        }
    }

    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }

    /**
     * @return string|int|OAuthToken|Money|bool|array<mixed,mixed>
     * @throws ResultException
     */
    public function ensureValue(): string|int|OAuthToken|Money|bool|array
    {
        if (!$this->wasSuccessful()) {
            throw new ResultException($this->errorMessage);
        }

        return $this->nonNullValue;
    }

    /**
     * @return string|int|OAuthToken|Money|bool|array<mixed,mixed>
     */
    public function getValue(): string|int|OAuthToken|Money|bool|array
    {
        return $this->nonNullValue;
    }

    public function getString(): string
    {
        Assert::that((is_string($this->nonNullValue) && $this->nonNullValue !== '')
            , ResultErrorMessage::STRING
        );

        /** @var string */
        return $this->nonNullValue;
    }

    public function getInt(): int
    {
        Assert::that(is_int($this->nonNullValue)
            , ResultErrorMessage::INTEGER
        );

        /** @var int */
        return $this->nonNullValue;
    }

    public function getBoolean(): bool
    {
        Assert::that(is_bool($this->nonNullValue)
            , ResultErrorMessage::BOOLEAN
        );

        /** @var bool */
        return $this->nonNullValue;
    }

    public function getMoney(): Money
    {
        Assert::that(is_object($this->nonNullValue) && get_class($this->nonNullValue) == Money::class
            , ResultErrorMessage::MONEY
        );

        /** @var Money */
        return $this->nonNullValue;
    }

    /**
     * @return array<mixed,mixed>
     */
    public function getArray(): array
    {
        Assert::that(is_array($this->nonNullValue)
            , ResultErrorMessage::ARRAY
        );

        /** @var array<mixed,mixed> */
        return $this->nonNullValue;
    }

    public function getOAuthToken(): OAuthToken
    {
        Assert::that(is_object($this->nonNullValue) && get_class($this->nonNullValue) == OAuthToken::class
            , ResultErrorMessage::OAUTHTOKEN
        );

        /** @var OAuthToken */
        return $this->nonNullValue;
    }

    public function wasSuccessful(): bool
    {
        return null !== $this->value;
    }

    public function wasNotSuccessful(): bool
    {
        return null === $this->value;
    }

    /**
     * @param string|int|OAuthToken|Money|bool|array<mixed,mixed> $value
     * @return Result
     */
    public static function OK(string|int|OAuthToken|Money|bool|array $value): Result
    {
        return new self($value);
    }

    public static function ERROR(string $errorMessage): Result
    {
        return new self(null, $errorMessage);
    }
}
