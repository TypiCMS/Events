<?php

namespace TypiCMS\Modules\Events\Models;

use Dimsav\Translatable\Translatable;
use Laracasts\Presenter\PresentableTrait;
use TypiCMS\Modules\Core\Models\Base;
use TypiCMS\Modules\History\Traits\Historable;

class Event extends Base
{
    use Historable;
    use Translatable;
    use PresentableTrait;

    protected $presenter = 'TypiCMS\Modules\Events\Presenters\ModulePresenter';

    protected $dates = ['start_date', 'end_date'];

    protected $fillable = [
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'image',
    ];

    /**
     * Translatable model configs.
     *
     * @var array
     */
    public $translatedAttributes = [
        'title',
        'slug',
        'status',
        'venue',
        'address',
        'summary',
        'body',
    ];

    protected $appends = ['status', 'title', 'thumb'];

    /**
     * Columns that are file.
     *
     * @var array
     */
    public $attachments = [
        'image',
    ];

    /**
     * Append status attribute from translation table.
     *
     * @return string
     */
    public function getStatusAttribute($value)
    {
        return $value;
    }

    /**
     * Append title attribute from translation table.
     *
     * @return string title
     */
    public function getTitleAttribute($value)
    {
        return $value;
    }

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
