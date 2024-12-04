<?php
namespace App\States\ModuleStatus;
class Draft extends ModuleStatus
{
    public static $name = 'draft';
    public function color(): string
    {
        return 'green';
    }
}
