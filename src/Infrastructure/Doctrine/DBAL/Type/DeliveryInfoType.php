<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\DBAL\Type;

use App\Domain\ValueObject\DeliveryInfo;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class DeliveryInfoType extends Type
{
    public function getSQLDeclaration(array $column, AbstractPlatform $platform)
    {
        return 'jsonb';
    }

    public function getName(): string
    {
        return 'deliveryInfo';
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (!$value) {
            return null;
        }

        if (!$value instanceof DeliveryInfo) {
            throw new \InvalidArgumentException('CustomerInfo class required');
        }

        return json_encode([
            'transport' => (string) $value->getTransport(),
            'deliveredAt' => (string) $value->getDeliveredAt()->format(\DateTimeInterface::ATOM),
        ], JSON_THROW_ON_ERROR);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?DeliveryInfo
    {
        if (!$value) {
            return null;
        }

        $data = json_decode($value, true);

        return new DeliveryInfo(
            $data['transport'],
            new \DateTimeImmutable($data['deliveredAt'])
        );
    }
}
