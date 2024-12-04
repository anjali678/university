<?php

namespace App\src\Student\Module\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\States\ModuleStatus\Published;
use Illuminate\Database\Eloquent\Collection;

class ModuleController extends Controller
{
    /**
     * @return Collection
     */
    public function index(): Collection
    {
        return Module::with('semesters', 'ModuleTeacher')
            ->where('state', Published::class)
            ->select(['course_id', 'code', 'name', 'credit', 'type', 'state'])
            ->get();
    }
}

