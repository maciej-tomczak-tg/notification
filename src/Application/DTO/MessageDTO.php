<?php

declare(strict_types=1);

namespace App\Application\DTO;

use App\Application\Ports\HasBody;
use App\Application\Ports\HasTitle;
use App\Domain\ValueObject\Message;

class MessageDTO implements HasTitle, HasBody
{
    public function __construct(private string $title, private string $body)
    {
    }

    public function getBody(): string
    {
        return $this->title;
    }

    public function getTitle(): string
    {
        return $this->body;
    }

    public function toValueObject(): Message
    {
        return new Message(
            $this->title,
            $this->body
        );
    }
}
