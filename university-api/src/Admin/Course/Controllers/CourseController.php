<?php

namespace App\src\Admin\Course\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\src\Admin\Course\Requests\CourseRequest;
use App\src\Admin\Course\Requests\UpdateCourseStateRequest;
use App\src\Admin\Course\Resources\CourseResource;
use App\States\CourseStatus\Draft;
use App\States\CourseStatus\Published;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;

class CourseController extends Controller
{
    /**
     * @return Collection
     */
    public function index(): Collection
    {
        return Course::with('faculty', 'modules')->get();
    }

    /**
     * @param CourseRequest $request
     * @return CourseResource
     */
    public function store(CourseRequest $request): CourseResource
    {
        return new CourseResource(Course::create($request->validated()));
    }

    /**
     * @param Course $course
     * @param CourseRequest $request
     * @return CourseResource
     */
    public function update(Course $course, CourseRequest $request): CourseResource
    {
        $course->update($request->validated());
        return new CourseResource($course->refresh());
    }

    /**
     * @param Course $course
     * @return JsonResponse
     */
    public function destroy(Course $course): JsonResponse
    {
        $course->delete();
        return response()->json(['message' => 'Course deleted successfully.']);
    }

    /**
     * @param UpdateCourseStateRequest $request
     * @param Course $course
     * @return JsonResponse
     */
    public function updateState(UpdateCourseStateRequest $request, Course $course): JsonResponse
    {
        $stateClass = $request->validated()['state'] === 'published' ? Published::class : Draft::class;

        if ($course->state->canTransitionTo($stateClass)) {
            $course->state->transitionTo($stateClass);
            $course->save();
            return response()->json(['message' => 'Course state updated successfully.']);
        }
        return response()->json(['error' => 'Invalid state transition.'], 400);
    }

}

