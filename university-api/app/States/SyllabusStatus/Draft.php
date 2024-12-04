<?php
namespace App\States\SyllabusStatus;
class Draft extends SyllabusStatus
{
    public static $name = 'draft';
    public function color(): string
    {
        return 'green';
    }
}
