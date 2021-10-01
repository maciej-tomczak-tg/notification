<?php

declare(strict_types=1);

namespace App\Infrastructure\Service;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Uuid4GeneratorService
{
    public function generate(): UuidInterface
    {
        return Uuid::uuid4();
    }
}
