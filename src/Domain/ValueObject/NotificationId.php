<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

class NotificationId
{
    public function __construct(
        private string $value
    ) {
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
