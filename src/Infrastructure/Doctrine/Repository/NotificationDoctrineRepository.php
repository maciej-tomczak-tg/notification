<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Repository;

use App\Domain\Exception\NotFoundException;
use App\Domain\Model\Notification;
use App\Domain\Repository\NotificationRepository;
use App\Domain\ValueObject\NotificationId;
use Doctrine\ORM\EntityManagerInterface;

class NotificationDoctrineRepository implements NotificationRepository
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function add(Notification $notification): void
    {
        $this->entityManager->persist($notification);
    }

    public function get(NotificationId $notificationId): Notification
    {
        /** @var Notification|null $notification */
        $notification = $this->entityManager->getRepository(Notification::class)->find(
            $notificationId
        );

        if (null === $notification) {
            throw new NotFoundException(sprintf('Cannot find Notification with %s', (string) $notificationId));
        }

        return $notification;
    }
}
