<?php
namespace App\States\CourseStatus;
class Published extends CourseStatus
{
    public static $name = 'published';
    public function color(): string
    {
        return 'success';
    }
}
