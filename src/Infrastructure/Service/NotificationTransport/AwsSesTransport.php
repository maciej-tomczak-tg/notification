<?php

declare(strict_types=1);

namespace App\Infrastructure\Service\NotificationTransport;

use App\Application\DTO\MessageDTO;
use App\Application\Exception\TransportException;
use App\Application\Ports\HasEmail;
use App\Application\Ports\NotificationTransport;
use Psr\Log\LoggerInterface;

class AwsSesTransport implements NotificationTransport
{
    private \SimpleEmailService $emailService;

    public function __construct(
        private string $recipientEmail,
        private string $awsAccessKey,
        private string $awsSecretKey,
        private LoggerInterface $logger
    )
    {
        $this->emailService = new \SimpleEmailService($this->awsAccessKey, $this->awsSecretKey);
    }

    public function send(HasEmail $customerDTO, MessageDTO $messageDTO): void
    {
        try {

            $email = new \SimpleEmailServiceMessage();
            $email->addTo($customerDTO->getEmail());
            $email->setFrom($this->recipientEmail);
            $email->setSubject($messageDTO->getTitle());
            $email->setMessageFromString($messageDTO->getBody());

            $this->emailService->sendEmail($email);
        } catch (\Throwable $throwable) {
            $this->logger->notice('Delivery failed:'. $throwable->getMessage());

            throw new TransportException($throwable->getMessage());
        }
    }

    public function getName(): string
    {
        return 'aws_ses';
    }

    public static function getPriority(): int
    {
        return 20;
    }
}
