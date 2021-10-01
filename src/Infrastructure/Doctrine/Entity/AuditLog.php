<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class AuditLog
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="string")
     */
    private string $auditLogId;
    /**
     * @ORM\Column(type="string")
     */
    private string $class;
    /**
     * @ORM\Column(type="text")
     */
    private string $params;
    /**
     * @ORM\Column(type="date_immutable")
     */
    private \DateTimeImmutable $createdAt;

    public function __construct(
        string $auditLogId,
        string $class,
        string $params
    ) {
        $this->createdAt = new \DateTimeImmutable();
        $this->auditLogId = $auditLogId;
        $this->class = $class;
        $this->params = $params;
    }
}
