<?php

declare(strict_types=1);

namespace App\Application\Ports;

interface HasCustomerIdentity
{
    public function getCustomerId(): string;
}
