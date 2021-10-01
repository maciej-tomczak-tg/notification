<?php

declare(strict_types=1);

namespace App\Domain;

interface AggregateRoot
{
    public function raiseEvent(Event $event): void;

    /**
     * @return Event[]
     */
    public function flushEvents(): array;
}
