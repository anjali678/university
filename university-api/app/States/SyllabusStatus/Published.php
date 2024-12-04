<?php
namespace App\States\SyllabusStatus;
class Published extends SyllabusStatus
{
    public static $name = 'published';
    public function color(): string
    {
        return 'success';
    }
}
