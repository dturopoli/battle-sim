<?php

namespace App\Model;

class UnitTypes
{
    public const INFANTRY = 'infantry';
    public const CAVALRY = 'cavalry';
    public const ARTILLERY = 'artillery';

    private const VALID_TYPES = [
        self::INFANTRY,
        self::CAVALRY,
        self::ARTILLERY
    ];

    /**
     * @return string[]
     */
    public static function validTypes(): array
    {
        return self::VALID_TYPES;
    }
}
