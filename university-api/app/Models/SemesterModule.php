<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class SemesterModule extends Pivot
{
    protected $fillable = ['semester_id', 'module_id'];
}




