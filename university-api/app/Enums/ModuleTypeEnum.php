<?php
namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self Mandatory()
 * @method static self Elective()
 */
class ModuleTypeEnum extends Enum
{
    protected static function labels(): array
    {
        return [
            'Mandatory' => 'mandatory',
            'Elective' => 'elective',
        ];
    }
}


