<?php

declare(strict_types=1);

namespace App\Application\Ports;

interface HasPhone
{
    public function getPhoneNumber(): string;
}
