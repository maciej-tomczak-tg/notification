<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

class Message
{
    public function __construct(private string $title, private string $body)
    {
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getBody(): string
    {
        return $this->body;
    }
}
