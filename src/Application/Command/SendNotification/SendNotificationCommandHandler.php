<?php

declare(strict_types=1);

namespace App\Application\Command\SendNotification;

use App\Domain\Model\Notification;
use App\Domain\Repository\NotificationRepository;
use App\Domain\ValueObject\NotificationId;

class SendNotificationCommandHandler
{
    public function __construct(
        private NotificationRepository $notificationRepository
    ) {
    }

    public function __invoke(SendNotificationCommand $command): void
    {
        $notification = new Notification(
            new NotificationId($command->getNotificationid()),
            $command->getMessage()->toValueObject(),
            $command->getCustomer()->toValueObject()
        );
        $this->notificationRepository->add($notification);
    }
}
