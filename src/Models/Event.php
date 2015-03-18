<?php
namespace TypiCMS\Modules\Events\Models;

use Carbon\Carbon;
use Dimsav\Translatable\Translatable;
use TypiCMS\Models\Base;
use TypiCMS\Modules\History\Traits\Historable;
use TypiCMS\Presenters\PresentableTrait;

class Event extends Base
{

    use Historable;
    use Translatable;
    use PresentableTrait;

    protected $presenter = 'TypiCMS\Modules\Events\Presenters\ModulePresenter';

    protected $dates = ['start_date', 'end_date'];

    protected $fillable = array(
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'image',
        // Translatable columns
        'title',
        'slug',
        'status',
        'summary',
        'body',
    );

    /**
     * Translatable model configs.
     *
     * @var array
     */
    public $translatedAttributes = array(
        'title',
        'slug',
        'status',
        'summary',
        'body',
    );

    protected $appends = ['status', 'title', 'thumb'];

    /**
     * Columns that are file.
     *
     * @var array
     */
    public $attachments = array(
        'image',
    );
}
