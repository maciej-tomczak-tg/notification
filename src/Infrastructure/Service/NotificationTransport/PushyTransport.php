<?php

declare(strict_types=1);

namespace App\Infrastructure\Service\NotificationTransport;

use App\Application\DTO\MessageDTO;
use App\Application\Exception\TransportException;
use App\Application\Ports\HasCustomerIdentity;
use App\Application\Ports\NotificationTransport;

class PushyTransport implements NotificationTransport
{
    public function send(HasCustomerIdentity $customerDTO, MessageDTO $messageDTO): void
    {
        throw new TransportException('not implemented yet');
        $identity = $customerDTO->getCustomerId();

        echo "pushy: notifying to: $identity \n";
    }

    public function getName(): string
    {
        return 'pushy';
    }

    public static function getPriority(): int
    {
        return 30;
    }
}
