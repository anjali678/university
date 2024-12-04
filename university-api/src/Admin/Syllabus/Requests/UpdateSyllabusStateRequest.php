<?php

namespace App\src\Admin\Syllabus\Requests;

use App\States\SyllabusStatus\SyllabusStatus;
use Illuminate\Foundation\Http\FormRequest;
use Spatie\ModelStates\Validation\ValidStateRule;

class UpdateSyllabusStateRequest extends FormRequest
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
            'state' => ['required', new ValidStateRule(SyllabusStatus::class)],
        ];
    }
}
