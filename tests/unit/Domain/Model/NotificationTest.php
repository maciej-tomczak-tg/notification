<?php

namespace unit\Domain\Model;

use App\Domain\Model\Notification;
use App\Domain\ValueObject\CustomerInfo;
use App\Domain\ValueObject\DeliveryInfo;
use App\Domain\ValueObject\Message;
use App\Domain\ValueObject\NotificationId;
use PHPUnit\Framework\TestCase;

class NotificationTest extends TestCase
{
    public function testCreation()
    {
        $notificationId = $this->createMock(NotificationId::class);
        $message = $this->createMock(Message::class);
        $customerInfo = $this->createMock(CustomerInfo::class);

        $notification = new Notification(
            $notificationId,
            $message,
            $customerInfo
        );

        $this->assertInstanceOf(Notification::class, $notification);
    }

    public function testIsDelivered()
    {
        $notificationId = $this->createMock(NotificationId::class);
        $message = $this->createMock(Message::class);
        $customerInfo = $this->createMock(CustomerInfo::class);

        $notification = new Notification(
            $notificationId,
            $message,
            $customerInfo
        );

        $this->assertFalse($notification->isDelivered());

        $notification->markAsDelivered($this->createMock(DeliveryInfo::class));
        $this->assertTrue($notification->isDelivered());

        $this->assertInstanceOf(Notification::class, $notification);
    }
}
