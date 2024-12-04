<?php

namespace App\src\Admin\Course\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CourseRequest extends FormRequest
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
        $courseId = $this->route('course')?->id;
        return [
            'name' => 'required|string|max:255',
            'seo_url' => [
                'required',
                'string',
                Rule::unique('courses')->ignore($courseId),
            ],
            'faculty_id' => 'required|exists:faculties,id',
            'credit' => 'required|integer',
        ];
    }
}
