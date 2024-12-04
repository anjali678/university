<?php
namespace App\States\CourseStatus;
class Draft extends CourseStatus
{
    public static $name = 'draft';
    public function color(): string
    {
        return 'green';
    }
}
