<?php

declare(strict_types=1);

namespace App\Application\Ports;

interface HasBody
{
    public function getBody(): string;
}
