<?php
namespace TypiCMS\Modules\Events\Http\Requests;

use TypiCMS\Http\Requests\AbstractFormRequest;

class FormRequest extends AbstractFormRequest {

    public function rules()
    {
        $rules = [
            'start_date' => 'required|date',
            'start_time' => 'date_format:G:i',
            'end_date'   => 'required|date',
            'end_time'   => 'date_format:G:i',
        ];
        foreach (config('translatable.locales') as $locale) {
            $rules[$locale . '.slug'] = [
                'required_with:' . $locale . '.title',
                'required_if:' . $locale . '.status,1',
                'alpha_dash',
                'max:255',
            ];
            $rules[$locale . '.title'] = 'max:255';
        }
        return $rules;
    }
}
