<?php

namespace TypiCMS\Modules\Events\Http\Requests;

use TypiCMS\Modules\Core\Http\Requests\AbstractFormRequest;

class RegistrationFormRequest extends AbstractFormRequest
{
    /** @return array<string, string> */
    public function rules(): array
    {
        return [
            'number_of_people' => 'required|integer|min:1',
            'message' => 'nullable|max:5000',
            'my_name' => 'honeypot',
            'my_time' => 'required|honeytime:5',
        ];
    }
}
