<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model\Notification;
use App\Domain\ValueObject\NotificationId;

interface NotificationRepository
{
    public function add(Notification $notification): void;

    public function get(NotificationId $notificationId): Notification;
}
