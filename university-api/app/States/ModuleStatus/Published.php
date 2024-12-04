<?php
namespace App\States\ModuleStatus;
class Published extends ModuleStatus
{
    public static $name = 'published';
    public function color(): string
    {
        return 'success';
    }
}
