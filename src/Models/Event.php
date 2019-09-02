<?php

namespace TypiCMS\Modules\Events\Models;

use Illuminate\Pagination\Paginator;
use Laracasts\Presenter\PresentableTrait;
use Spatie\Translatable\HasTranslations;
use TypiCMS\Modules\Core\Models\Base;
use TypiCMS\Modules\Events\Presenters\ModulePresenter;
use TypiCMS\Modules\Files\Models\File;
use TypiCMS\Modules\Files\Traits\HasFiles;
use TypiCMS\Modules\History\Traits\Historable;

class Event extends Base
{
    use HasFiles;
    use HasTranslations;
    use Historable;
    use PresentableTrait;

    protected $presenter = ModulePresenter::class;

    protected $dates = ['start_date', 'end_date'];

    protected $guarded = ['id', 'exit'];

    protected $appends = ['thumb'];

    public $translatable = [
        'title',
        'slug',
        'status',
        'venue',
        'address',
        'summary',
        'body',
        'url',
    ];

    public function upcoming($number = null)
    {
        $query = $this->where('end_date', '>=', date('Y-m-d'))
            ->orderBy('start_date');
        if ($number) {
            $query->take($number);
        }

        return $query->get();
    }

    public function past($number = null)
    {
        $query = $this->where('end_date', '<', date('Y-m-d'))
            ->order();
        if ($number) {
            $query->take($number);
        }

        return $query->get();
    }

    public function adjacent($direction, $model, $category_id = null, array $with = [], $all = false)
    {
        $currentModel = $model;
        if ($currentModel->end_date < date('Y-m-d')) {
            $models = $this->past();
        } else {
            $models = $this->upcoming();
        }
        foreach ($models as $key => $model) {
            if ($currentModel->id === $model->id) {
                $adjacentKey = $key + $direction;

                return isset($models[$adjacentKey]) ? $models[$adjacentKey] : null;
            }
        }
    }

    /**
     * Append thumb attribute.
     *
     * @return string
     */
    public function getThumbAttribute()
    {
        return $this->present()->image(null, 54);
    }

    /**
     * This model belongs to one image.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function image()
    {
        return $this->belongsTo(File::class, 'image_id');
    }
}
