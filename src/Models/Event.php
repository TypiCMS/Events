<?php

namespace TypiCMS\Modules\Events\Models;

use Laracasts\Presenter\PresentableTrait;
use Spatie\Translatable\HasTranslations;
use TypiCMS\Modules\Core\Models\Base;
use TypiCMS\Modules\History\Traits\Historable;

class Event extends Base
{
    use HasTranslations;
    use Historable;
    use PresentableTrait;

    protected $presenter = 'TypiCMS\Modules\Events\Presenters\ModulePresenter';

    protected $dates = ['start_date', 'end_date'];

    protected $guarded = ['id'];

    public $translatable = [
        'title',
        'slug',
        'status',
        'venue',
        'address',
        'summary',
        'body',
    ];

    protected $appends = ['thumb'];

    public $attachments = [
        'image',
    ];

    /**
     * Append thumb attribute.
     *
     * @return string
     */
    public function getThumbAttribute()
    {
        return $this->present()->thumbSrc(null, 22);
    }
}
