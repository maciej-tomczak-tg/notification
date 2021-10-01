<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Application\DTO\CustomerDTO;
use App\Application\DTO\MessageDTO;
use App\Application\Ports\NotificationTransport;
use PHPUnit\Framework\TestCase;

class NotificationServiceTest extends TestCase
{
    public function testSending()
    {
        $transport = new class() implements NotificationTransport {
            public function send(CustomerDTO $customerDTO, MessageDTO $messageDTO): void
            {
            }

            public function getName(): string
            {
                return 'some transport';
            }

            public static function getPriority(): int
            {
                return 20;
            }
        };

        $service = new NotificationService([new $transport()]);
        $return = $service->send($this->createMock(CustomerDTO::class), $this->createMock(MessageDTO::class));
        $this->assertEquals('some transport', $return);
    }
}
