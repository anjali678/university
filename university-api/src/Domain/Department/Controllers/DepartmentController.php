<?php

namespace App\src\Domain\Department\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Database\Eloquent\Collection;

class DepartmentController extends Controller
{
    /**
     * @return Collection
     */
    public function index(): Collection
    {
        return Department::with('faculty')->get();
    }

}

