<?php

declare(strict_types=1);

namespace App\Domain;

trait EventCollector
{
    /**
     * @var Event[]
     */
    private $events = [];

    public function raiseEvent(Event $event): void
    {
        $this->events[] = $event;
    }

    public function flushEvents(): array
    {
        $events = $this->events;
        $this->events = [];

        return $events;
    }
}
