<?php

declare(strict_types=1);

namespace App\Infrastructure\Middleware;

use App\Application\Command\Command;
use App\Infrastructure\Doctrine\Entity\AuditLog;
use App\Infrastructure\Doctrine\Repository\AuditLogDoctrineRepository;
use App\Infrastructure\Service\Uuid4GeneratorService;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;

class AuditLogMiddleware implements MiddlewareInterface
{
    public function __construct(
        private AuditLogDoctrineRepository $auditLogRepository,
        private SerializerInterface $serializer,
        private Uuid4GeneratorService $uuid4Generator
    ) {
    }

    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        $command = $envelope->getMessage();
        if ($command instanceof Command) {
            $audit = new AuditLog(
                $this->uuid4Generator->generate()->toString(),
                $command::class,
                $this->serializer->serialize($command, 'json')
            );
            $this->auditLogRepository->add($audit);
        }

        return $stack->next()->handle($envelope, $stack);
    }
}
