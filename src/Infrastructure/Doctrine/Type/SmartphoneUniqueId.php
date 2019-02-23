<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Type;

use App\Entity\Smartphone\ValueObject\Id;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;
use Ramsey\Uuid\Uuid;

final class SmartphoneUniqueId extends Type
{
    public const NAME = 'smartphone_unique_id';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        return $platform->getGuidTypeDeclarationSQL($fieldDeclaration);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Id
    {
        if (empty($value)) {
            return null;
        }

        if ($value instanceof SmartphoneUniqueId) {
            return $value;
        }

        try {
            $uuid = Id::fromString((string) $value);
        } catch (\InvalidArgumentException $e) {
            throw ConversionException::conversionFailed($value, static::NAME);
        }

        return $uuid;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (empty($value)) {
            return null;
        }

        if (
            $value instanceof SmartphoneUniqueId
            || (
                (is_string($value) || method_exists($value, '__toString'))
                && Uuid::isValid((string) $value)
            )
        ) {
            return (string) $value;
        }

        throw ConversionException::conversionFailed($value, static::NAME);
    }

    public function getName(): string
    {
        return static::NAME;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}