<?php

namespace TypiCMS\Modules\Events\Http\Requests;

use TypiCMS\Modules\Core\Http\Requests\AbstractFormRequest;

class FormRequest extends AbstractFormRequest
{
    public function rules()
    {
        $rules = [
            'start_date' => 'required|date_format:Y-m-d G:i:s',
            'end_date'   => 'required|date_format:Y-m-d G:i:s',
            'image'      => 'image|max:2000',
            'price'      => 'numeric',
            'currency'   => 'max:3',
        ];
        foreach (config('translatable.locales') as $locale) {
            $rules[$locale.'.slug'] = [
                'required_with:'.$locale.'.title',
                'required_if:'.$locale.'.status,1',
                'alpha_dash',
                'max:255',
            ];
            $rules[$locale.'.title'] = 'max:255';
            $rules[$locale.'.location'] = 'max:255';
        }

        return $rules;
    }
}
