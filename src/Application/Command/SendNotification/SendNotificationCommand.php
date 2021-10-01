<?php

declare(strict_types=1);

namespace App\Application\Command\SendNotification;

use App\Application\Command\Command;
use App\Application\DTO\CustomerDTO;
use App\Application\DTO\MessageDTO;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

class SendNotificationCommand implements Command
{
    /**
     * @var string
     * @Assert\Uuid()
     * @Assert\NotBlank()
     * @Serializer\Type("string")
     */
    private $notificationid;
    /**
     * @var MessageDTO
     * @Assert\Type("string")
     * @Assert\NotNull()
     */
    private $message;
    /**
     * @var CustomerDTO
     * @Assert\Type("string")
     * @Assert\NotNull()
     * @Assert\Valid()
     * @Serializer\Type("App\Application\DTO\CustomerDTO")
     */
    private $customer;

    public function __construct(
        string $notificationid,
        MessageDTO $message,
        CustomerDTO $customer
    ) {
        $this->notificationid = $notificationid;
        $this->message = $message;
        $this->customer = $customer;
    }

    public function getNotificationid(): string
    {
        return $this->notificationid;
    }

    public function getMessage(): MessageDTO
    {
        return $this->message;
    }

    public function getCustomer(): CustomerDTO
    {
        return $this->customer;
    }
}
