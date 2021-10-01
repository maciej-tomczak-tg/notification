<?php

declare(strict_types=1);

namespace App\Domain\Event;

use App\Domain\Event;
use JMS\Serializer\Annotation as Serializer;

class NotificationCreatedEvent implements Event
{
    /**
     * @Serializer\Type("string")
     */
    private string $notificationId;

    public function __construct(
        string $notificationId
    ) {
        $this->notificationId = $notificationId;
    }

    public function getNotificationId(): string
    {
        return $this->notificationId;
    }
}
