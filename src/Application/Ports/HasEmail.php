<?php

declare(strict_types=1);

namespace App\Application\Ports;

interface HasEmail
{
    public function getEmail(): string;
}
