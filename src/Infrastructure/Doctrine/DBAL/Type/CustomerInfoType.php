<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\DBAL\Type;

use App\Domain\ValueObject\CustomerId;
use App\Domain\ValueObject\CustomerInfo;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Phone;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class CustomerInfoType extends Type
{
    public function getSQLDeclaration(array $column, AbstractPlatform $platform)
    {
        return 'jsonb';
    }

    public function getName(): string
    {
        return 'customerInfo';
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (!$value) {
            return null;
        }

        if (!$value instanceof CustomerInfo) {
            throw new \InvalidArgumentException('CustomerInfo class required');
        }

        return json_encode([
            'customerId' => (string) $value->getCustomerId(),
            'email' => (string) $value->getEmail(),
            'phone' => (string) $value->getPhone(),
        ], JSON_THROW_ON_ERROR);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?CustomerInfo
    {
        if (!$value) {
            return null;
        }

        $data = json_decode($value, true);

        return new CustomerInfo(
            new CustomerId($data['customerId']),
            new Email($data['email']),
            new Phone($data['phone'])
        );
    }
}
