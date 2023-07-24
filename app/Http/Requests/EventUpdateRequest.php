<?php

namespace App\Http\Requests;

use App\Rules\EventEndDateRule;
use App\Rules\EventStartDateRule;
use Illuminate\Foundation\Http\FormRequest;

class EventUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => $this->validationRulesForPutVsPatch(['string', 'max:200']),
            'start_date' => $this->validationRulesForPutVsPatch(['date', 'date_format:Y-m-d H:i:s', new EventStartDateRule()]),
            'end_date' => $this->validationRulesForPutVsPatch(['date', 'date_format:Y-m-d H:i:s', new EventEndDateRule()]),
        ];
    }

    /**
     * Creates appropriate validation rules for PUT vs PATCH
     */
    protected function validationRulesForPutVsPatch(array $rules): array
    {
        $rules[] = (request()->method() === 'PATCH' ? 'sometimes' : 'required');

        return $rules;
    }
}
