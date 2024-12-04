<?php

namespace App\src\Admin\Syllabus\Requests;

use App\Enums\ModuleTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Spatie\Enum\Laravel\Rules\EnumRule;

class SyllabusRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'course_id' => 'required|exists:courses,id',
            'year' => 'required|integer',
            'semesters' => 'required|array',
            'semesters.*.id' => 'nullable|exists:semesters,id',
            'semesters.*.name' => 'required|string',
            'semesters.*.total_credit' => 'required|integer',
            'semesters.*.modules' => 'required|array',
            'semesters.*.modules.*.id' => 'required|exists:modules,id',
            'semesters.*.modules.*.teacher_id' => 'required|exists:users,id',
        ];
    }
}
