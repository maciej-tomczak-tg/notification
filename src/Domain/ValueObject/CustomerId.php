<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

class CustomerId
{
    public function __construct(private string $customerId)
    {
    }

    public function __toString(): string
    {
        return $this->customerId;
    }
}
