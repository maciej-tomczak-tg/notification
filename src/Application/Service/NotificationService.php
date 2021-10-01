<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Application\DTO\CustomerDTO;
use App\Application\DTO\MessageDTO;
use App\Application\Exception\DeliveryFailedException;
use App\Application\Exception\TransportException;
use App\Application\Ports\NotificationTransport;

class NotificationService
{
    /**
     * @param NotificationTransport[] $notificationTransports
     */
    public function __construct(
        private iterable $notificationTransports
    ) {
    }

    public function send(CustomerDTO $customer, MessageDTO $message): string
    {
        $deliverySuccess = false;
        $transportUsed = '';
        foreach ($this->notificationTransports as $transport) {
            try {
                $transport->send($customer, $message);
                $deliverySuccess = true;
                $transportUsed = $transport->getName();
                break;
            } catch (TransportException $transportException) {
                echo $transportException->getMessage();
                continue;
            }
        }

        if (!$deliverySuccess) {
            throw new DeliveryFailedException();
        }

        return $transportUsed;
    }
}
