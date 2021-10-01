<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\DBAL\Type;

use App\Domain\ValueObject\NotificationId;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class NotificationIdType extends AbstractType
{
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        return parent::getUuidSqlDeclaration($fieldDeclaration, $platform);
    }

    protected function getClassName(): string
    {
        return NotificationId::class;
    }

    public function getName()
    {
        return 'notificationId';
    }
}
