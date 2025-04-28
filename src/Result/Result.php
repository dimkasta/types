<?php

namespace Iconic\Result;

use Brick\Money\Money;
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
    private string $message;

    /**
     * @param string|int|OAuthToken|Money|bool|array<mixed,mixed>|null $value
     * @param string $message
     */
    public function __construct(
        null|string|int|OAuthToken|Money|bool|array $value,
        string $message = '',
    ) {
        $this->message = $message;
        $this->value = $value;
        if ( !is_null($value)) {
            $this->nonNullValue = $value;
        } else {
            $this->nonNullValue = '';
        }
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return string|int|OAuthToken|Money|bool|array<mixed,mixed>
     * @throws ResultException
     */
    public function ensureValue(): string|int|OAuthToken|Money|bool|array
    {
        if (!$this->wasSuccessful()) {
            throw new ResultException($this->message);
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

    public function wasSuccessful(): bool
    {
        return null !== $this->value;
    }
}
