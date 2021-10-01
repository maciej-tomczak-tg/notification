<?php

declare(strict_types=1);

namespace App\Application\Ports;

use App\Application\DTO\CustomerDTO;
use App\Application\DTO\MessageDTO;

interface NotificationTransport
{
    public function send(CustomerDTO $customerDTO, MessageDTO $messageDTO): void;

    public function getName(): string;

    public static function getPriority(): int;
}
