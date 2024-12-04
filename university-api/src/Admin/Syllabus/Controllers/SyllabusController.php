<?php

namespace App\src\Admin\Syllabus\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\Syllabus;
use App\src\Admin\Syllabus\Requests\SyllabusRequest;
use App\src\Admin\Syllabus\Resources\SyllabusResource;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class SyllabusController extends Controller
{
    /**
     * @return Collection
     */
    public function index(): Collection
    {
        return Syllabus::with('semesters')->get();
    }

    /**
     * @param SyllabusRequest $request
     * @return SyllabusResource
     */
    public function store(SyllabusRequest $request): SyllabusResource
    {
        return DB::transaction(function () use ($request) {
            $data = $request->validated();
            $syllabus = Syllabus::create($data);

            foreach ($data['semesters'] as $semesterData) {
                // Create Semester
                $semester = $syllabus->semesters()->create($semesterData);

                foreach ($semesterData['modules'] as $moduleData) {
                    // Add module to semester
                    $semester->modules()->sync($moduleData);

                    $module = Module::findOrFail($moduleData['id']);
                    $moduleData['assigned_year'] = $data['year'];
                    // Assign teacher to module
                    $module->moduleTeachers()->create($moduleData);
                }
            }

            return new SyllabusResource($syllabus);
        });
    }

    /**
     * @param Syllabus $syllabus
     * @param SyllabusRequest $request
     * @return SyllabusResource
     */
    public function update(Syllabus $syllabus, SyllabusRequest $request): SyllabusResource
    {
        return DB::transaction(function () use ($request, $syllabus) {
            $data = $request->validated();
            $syllabus->update($data);

            // Handle semesters
            foreach ($data['semesters'] as $semesterData) {
                $semester = $syllabus->semesters()->updateOrCreate(['id' => $semesterData['id'] ?? null], $semesterData);

                // Handle modules for the semester
                foreach ($semesterData['modules'] as $moduleData) {
                    // Sync the module with the semester
                    $semester->modules()->sync($moduleData);

                    $module = Module::findOrFail($moduleData['id']);
                    $module->moduleTeachers()->updateOrCreate(
                        ['teacher_id' => $moduleData['teacher_id'], 'assigned_year' => $data['year']]
                    );
                }
            }

            // Delete semesters/modules not included in the update request
            $semesterIds = array_column($data['semesters'], 'id');
            $syllabus->semesters()->whereNotIn('id', $semesterIds)->get()->each(function ($semester) {
                $semester->modules()->detach();
                $semester->delete();
            });

//            foreach ($syllabus->semesters as $semester) {
//                $moduleIds = array_column($semesterData['modules'], 'id');
//                $semester->modules()->whereNotIn('id', $moduleIds)->delete();
//            }

            return new SyllabusResource($syllabus->refresh());
        });
    }


    /**
     * @param Module $module
     * @return JsonResponse
     */
    public function destroy(Module $module): JsonResponse
    {
        $module->delete();
        return response()->json(['message' => 'Module deleted successfully.']);
    }

    /**
     * @param UpdateModuleStateRequest $request
     * @param Module $module
     * @return JsonResponse
     */
    public function updateState(UpdateModuleStateRequest $request, Module $module): JsonResponse
    {
        $stateClass = $request->validated()['state'] === 'published' ? Published::class : Draft::class;

        if ($module->state->canTransitionTo($stateClass)) {
            $module->state->transitionTo($stateClass);
            $module->save();
            return response()->json(['message' => 'Course state updated successfully.']);
        }
        return response()->json(['error' => 'Invalid state transition.'], 400);
    }
}

