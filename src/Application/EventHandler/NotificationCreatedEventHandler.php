<?php

declare(strict_types=1);

namespace App\Application\EventHandler;

use App\Application\DTO\CustomerDTO;
use App\Application\DTO\MessageDTO;
use App\Application\Service\NotificationService;
use App\Domain\Event\NotificationCreatedEvent;
use App\Domain\Repository\NotificationRepository;
use App\Domain\ValueObject\DeliveryInfo;
use App\Domain\ValueObject\NotificationId;

class NotificationCreatedEventHandler
{
    public function __construct(private NotificationService $notificationService, private NotificationRepository $notificationRepository)
    {
    }

    public function __invoke(NotificationCreatedEvent $event): void
    {
        $notificationId = new NotificationId($event->getNotificationId());
        $notification = $this->notificationRepository->get($notificationId);

        $transportUsed = $this->notificationService->send(
            new CustomerDTO(
                (string) $notification->getCustomerInfo()->getCustomerId(),
                (string) $notification->getCustomerInfo()->getEmail(),
                (string) $notification->getCustomerInfo()->getPhone()
            ),
            new MessageDTO(
                $notification->getMessage()->getTitle(),
                $notification->getMessage()->getBody()
            )
        );

        $notification->markAsDelivered(new DeliveryInfo($transportUsed, new \DateTimeImmutable()));
    }
}
