<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\DBAL\Type;

use App\Domain\ValueObject\Message;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class MessageType extends Type
{
    public function getSQLDeclaration(array $column, AbstractPlatform $platform)
    {
        return 'jsonb';
    }

    public function getName(): string
    {
        return 'message';
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (!$value) {
            return null;
        }

        if (!$value instanceof Message) {
            throw new \InvalidArgumentException('CustomerInfo class required');
        }

        return json_encode([
            'title' => $value->getTitle(),
            'body' => $value->getBody(),
        ], JSON_THROW_ON_ERROR);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Message
    {
        if (!$value) {
            return null;
        }

        $data = json_decode($value, true);

        return new Message(
            $data['title'],
            $data['body']
        );
    }
}
