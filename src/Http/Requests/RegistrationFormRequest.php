<?php

namespace TypiCMS\Modules\Events\Http\Requests;

use TypiCMS\Modules\Core\Http\Requests\AbstractFormRequest;

class RegistrationFormRequest extends AbstractFormRequest
{
    public function rules()
    {
        return [
            'number_of_people' => 'required|integer|min:1',
            'message' => 'nullable',
            'my_name' => 'honeypot',
            'my_time' => 'required|honeytime:5',
        ];
    }
}
