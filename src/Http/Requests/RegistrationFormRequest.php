<?php

declare(strict_types=1);

namespace TypiCMS\Modules\Events\Http\Requests;

use TypiCMS\Modules\Core\Http\Requests\AbstractFormRequest;

class RegistrationFormRequest extends AbstractFormRequest
{
    /** @return array<string, list<string>> */
    public function rules(): array
    {
        return [
            'number_of_people' => ['required', 'integer', 'min:1'],
            'message' => ['nullable', 'max:5000'],
        ];
    }
}
