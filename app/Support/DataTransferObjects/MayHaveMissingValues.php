<?php

declare(strict_types=1);

namespace App\Support\DataTransferObjects;

use ReflectionClass;
use ReflectionProperty;
use Spatie\DataTransferObject\Attributes\MapFrom;

trait MayHaveMissingValues
{
    public static function ensureMissingValues(mixed ...$parameters): array
    {
        if (\is_array($parameters[0] ?? null)) {
            $parameters = $parameters[0];
        }

        $class = new ReflectionClass(static::class);
        $properties = $class->getProperties(ReflectionProperty::IS_PUBLIC);

        foreach ($properties as $property) {
            if ($property->isStatic()) {
                continue;
            }

            $attributes = $property->getAttributes(MapFrom::class);

            if (empty($attributes)) {
                $name = $property->getName();
            } else {
                $name = \reset($attributes)->newInstance()->name;
            }

            if (! \array_key_exists($name, $parameters)) {
                $parameters[$name] = new MissingValue();
            }
        }

        return $parameters;
    }
}
