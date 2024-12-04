<?php

namespace App\src\AcademicHead\Module\Requests;

use App\States\CourseStatus\CourseStatus;
use App\States\ModuleStatus\ModuleStatus;
use Illuminate\Foundation\Http\FormRequest;
use Spatie\ModelStates\Validation\ValidStateRule;

class UpdateModuleStateRequest extends FormRequest
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
            'state' => ['required', new ValidStateRule(ModuleStatus::class)],
        ];
    }
}
