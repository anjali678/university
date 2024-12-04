<?php

namespace App\src\Admin\Module\Requests;

use App\Enums\ModuleTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Spatie\Enum\Laravel\Rules\EnumRule;

class ModuleRequest extends FormRequest
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
        $moduleId = $this->route('module')?->id;
        return [
            'code' => [
                'required',
                'string',
                Rule::unique('modules')->ignore($moduleId),
            ],
            'name' => 'required|string',
            'description' => 'nullable|string',
            'credit' => 'required|integer',
            'course_id' => 'required|exists:courses,id',
            'type' => ['required', new EnumRule(ModuleTypeEnum::class)],
        ];
    }
}
