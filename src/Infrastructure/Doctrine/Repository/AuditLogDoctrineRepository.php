<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Repository;

use App\Infrastructure\Doctrine\Entity\AuditLog;
use Doctrine\ORM\EntityManagerInterface;

class AuditLogDoctrineRepository
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function add(AuditLog $auditLog): void
    {
        $this->entityManager->persist($auditLog);
    }
}
