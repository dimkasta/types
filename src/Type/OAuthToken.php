<?php

namespace Iconic\Type;

use Carbon\Carbon;

class OAuthToken
{
    public function __construct(
        private readonly string $token,
        private readonly Carbon $expiresAt,
    ) {
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getExpiresAt(): Carbon
    {
        return $this->expiresAt;
    }
}
