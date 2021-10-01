<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine;

use App\Domain\AggregateRoot;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class DomainEventEmiterMiddleware implements MiddlewareInterface
{
    public function __construct(private EntityManagerInterface $entityManager, private MessageBusInterface $eventBus)
    {
    }

    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        $this->entityManager->getConnection()->beginTransaction();
        try {
            $envelope = $stack->next()->handle($envelope, $stack);
            $this->emitDomainEvents();
            $this->entityManager->flush();
            $this->entityManager->getConnection()->commit();

            return $envelope;
        } catch (\Throwable $exception) {
            $this->entityManager->getConnection()->rollBack();

            if ($exception instanceof HandlerFailedException) {
                // Remove all HandledStamp from the envelope so the retry will execute all handlers again.
                // When a handler fails, the queries of allegedly successful previous handlers just got rolled back.
                throw new HandlerFailedException($exception->getEnvelope()->withoutAll(HandledStamp::class), $exception->getNestedExceptions());
            }

            throw $exception;
        }
    }

    public function emitDomainEvents(): void
    {
        foreach ($this->getManagedAggregateRoots() as $aggregateRoot) {
            foreach ($aggregateRoot->flushEvents() as $event) {
                $this->eventBus->dispatch($event);
            }
        }
    }

    /**
     * @return AggregateRoot[]
     */
    private function getManagedAggregateRoots(): iterable
    {
        $unitOfWorker = $this->entityManager->getUnitOfWork();
        foreach ($unitOfWorker->getIdentityMap() as $entities) {
            foreach ($entities as $entity) {
                if ($entity instanceof AggregateRoot) {
                    yield $entity;
                }
            }
        }
    }
}
