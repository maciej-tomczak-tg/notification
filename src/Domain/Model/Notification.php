<?php

declare(strict_types=1);

namespace App\Domain\Model;

use App\Domain\AggregateRoot;
use App\Domain\Event\NotificationCreatedEvent;
use App\Domain\EventCollector;
use App\Domain\ValueObject\CustomerInfo;
use App\Domain\ValueObject\DeliveryInfo;
use App\Domain\ValueObject\Message;
use App\Domain\ValueObject\NotificationId;

class Notification implements AggregateRoot
{
    use EventCollector;

    private ?DeliveryInfo $deliveryInfo;

    public function __construct(
        private NotificationId $notificationId,
        private Message $message,
        private CustomerInfo $customerInfo
    ) {
        $this->raiseEvent(new NotificationCreatedEvent($this->notificationId->__toString()));
    }

    public function getCustomerInfo(): CustomerInfo
    {
        return $this->customerInfo;
    }

    public function getMessage(): Message
    {
        return $this->message;
    }

    public function markAsDelivered(DeliveryInfo $deliveryInfo): void
    {
        $this->deliveryInfo = $deliveryInfo;
    }
}
