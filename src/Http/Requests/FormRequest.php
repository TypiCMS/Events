<?php

namespace TypiCMS\Modules\Events\Http\Requests;

use TypiCMS\Modules\Core\Http\Requests\AbstractFormRequest;

class FormRequest extends AbstractFormRequest
{
    public function rules()
    {
        return [
            'start_date' => 'required|date_format:"Y-m-d\TH:i"',
            'end_date' => 'required|date_format:"Y-m-d\TH:i"|after_or_equal:start_date',
            'image_id' => 'nullable|integer',
            'title.*' => 'nullable|max:255',
            'slug.*' => 'nullable|alpha_dash|max:255|required_if:status.*,1|required_with:title.*',
            'venue.*' => 'nullable|max:255',
        ];
    }
}
