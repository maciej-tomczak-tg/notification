<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

class Email
{
    public function __construct(private string $value)
    {
        if (!filter_var($value, \FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException("Invalid email address '{$value}'");
        }
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
