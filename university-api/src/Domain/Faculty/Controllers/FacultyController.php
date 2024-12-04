<?php

namespace App\src\Domain\Faculty\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use Illuminate\Database\Eloquent\Collection;

class FacultyController extends Controller
{
    /**
     * @return Collection
     */
    public function index(): Collection
    {
        return Faculty::with('departments', 'courses')->get();
    }

}

