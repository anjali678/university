<?php

namespace App\src\AcademicHead\Module\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\src\AcademicHead\Module\Requests\ModuleRequest;
use App\src\AcademicHead\Module\Requests\UpdateModuleStateRequest;
use App\src\AcademicHead\Module\Resources\ModuleResource;
use App\States\ModuleStatus\Draft;
use App\States\ModuleStatus\Published;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;

class ModuleController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkEditTime')->only(['update', 'destroy', 'updateState']);
    }

    /**
     * @return Collection
     */
    public function index(): Collection
    {
        return Module::with('modules', 'syllabuse')->get();
    }

    /**
     * @param ModuleRequest $request
     * @return ModuleResource
     */
    public function store(ModuleRequest $request): ModuleResource
    {
        return new ModuleResource(Module::create($request->validated()));
    }

    /**
     * @param Module $module
     * @param ModuleRequest $request
     * @return ModuleResource
     */
    public function update(Module $module, ModuleRequest $request): ModuleResource
    {
        $module->update($request->validated());
        return new ModuleResource($module->refresh());
    }

    /**
     * @param Module $module
     * @return JsonResponse
     */
    public function destroy(Module $module): JsonResponse
    {
        $module->delete();
        return response()->json(['message' => 'Course deleted successfully.']);
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

