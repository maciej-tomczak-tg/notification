<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\DBAL\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use InvalidArgumentException;
use TypeError;

abstract class AbstractType extends Type
{
    /**
     * @param mixed $value
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        if (\is_string($value)) {
            return $value;
        }
        if (!is_a($value, $this->getClassName())) {
            throw new InvalidArgumentException(sprintf("Expected '%s', got '%s'", $this->getClassName(), \is_object($value) ? \get_class($value) : \gettype($value)));
        }

        return (string) $value;
    }

    /**
     * @return mixed|string
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ('' === $value) {
            return $value;
        }
        $className = $this->getClassName();

        try {
            return new $className($value);
        } catch (TypeError $error) {
            try {
                return new $className((int) $value);
            } catch (TypeError $error) {
                if (method_exists($className, 'createFromString')) {
                    /** @var callable $array */
                    $array = [$className, 'createFromString'];

                    return \call_user_func($array, $value);
                }

                throw $error;
            }
        }
    }

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        return $platform->getVarcharTypeDeclarationSQL($fieldDeclaration);
    }

    public function requiresSQLCommentHint(AbstractPlatform $abstractPlatform): bool
    {
        return true;
    }

    abstract protected function getClassName(): string;

    /**
     * @param string[] $fieldDeclaration
     */
    protected function getUuidSqlDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        return 'uuid';
    }
}
