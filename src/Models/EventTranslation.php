<?php

namespace TypiCMS\Modules\Events\Models;

use TypiCMS\Modules\Core\Models\BaseTranslation;

class EventTranslation extends BaseTranslation
{
    protected $fillable = [
        'title',
        'slug',
        'status',
        'venue',
        'address',
        'summary',
        'body',
    ];

    /**
     * get the parent model.
     */
    public function owner()
    {
        return $this->belongsTo('TypiCMS\Modules\Events\Models\Event', 'event_id');
    }
}
