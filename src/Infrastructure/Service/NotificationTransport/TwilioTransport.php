<?php

declare(strict_types=1);

namespace App\Infrastructure\Service\NotificationTransport;

use App\Application\Exception\TransportException;
use App\Application\Ports\HasBody;
use App\Application\Ports\HasPhone;
use App\Application\Ports\NotificationTransport;
use Psr\Log\LoggerInterface;
use Twilio\Rest\Client;

class TwilioTransport implements NotificationTransport
{
    private Client $twilio;

    public function __construct(
        private string $twilioSid,
        private string $twilioToken,
        private LoggerInterface $logger
    )
    {
        $this->twilio = new Client($this->twilioSid, $this->twilioToken);
    }

    public function send(HasPhone $customerDTO, HasBody $messageDTO): void
    {
        $phoneNumber = $customerDTO->getPhoneNumber();
        $body = $messageDTO->getBody();

        try {
            $message = $this->twilio->messages->create(
                $phoneNumber,
                [
                    'from' => $phoneNumber,
                    'body' => $body,
                ]
            );
            if (!$message->sid) {
                throw new \RuntimeException('No sid, something went wrong with sms delivery');
            }
        } catch (\Throwable $throwable) {
            $this->logger->notice('Delivery of message through twilio failed');

            throw new TransportException($throwable->getMessage());
        }

        echo "twilio notifying to: $phoneNumber \n";
    }

    public function getName(): string
    {
        return 'twilio';
    }

    public static function getPriority(): int
    {
        return 40;
    }
}
