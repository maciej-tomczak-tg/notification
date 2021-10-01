<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

class DeliveryInfo
{
    public function __construct(private string $transport, private \DateTimeImmutable $deliveredAt)
    {
    }

    public function getTransport(): string
    {
        return $this->transport;
    }

    public function getDeliveredAt(): \DateTimeImmutable
    {
        return $this->deliveredAt;
    }
}
