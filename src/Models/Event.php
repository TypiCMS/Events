<?php

namespace TypiCMS\Modules\Events\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Route;
use Laracasts\Presenter\PresentableTrait;
use Spatie\Translatable\HasTranslations;
use TypiCMS\Modules\Core\Models\Base;
use TypiCMS\Modules\Core\Models\File;
use TypiCMS\Modules\Core\Traits\HasFiles;
use TypiCMS\Modules\Core\Traits\Historable;
use TypiCMS\Modules\Events\Presenters\ModulePresenter;

class Event extends Base
{
    use HasFiles;
    use HasTranslations;
    use Historable;
    use PresentableTrait;

    protected string $presenter = ModulePresenter::class;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'start_date' => 'datetime:Y-m-d',
            'end_date' => 'datetime:Y-m-d',
        ];
    }

    protected $guarded = [];

    protected $appends = ['thumb'];

    public array $translatable = [
        'title',
        'slug',
        'status',
        'venue',
        'address',
        'summary',
        'body',
        'website',
    ];

    public function url($locale = null): string
    {
        $locale = $locale ?: app()->getLocale();
        $route = $locale . '::event';
        $slug = $this->translate('slug', $locale) ?: null;

        return Route::has($route) && $slug ? url(route($route, $slug)) : url('/');
    }

    public function upcoming($number = null)
    {
        $query = $this->published()
            ->where('end_date', '>=', date('Y-m-d'))
            ->orderBy('start_date');
        if ($number) {
            $query->take($number);
        }

        return $query->get();
    }

    public function past($number = null)
    {
        $query = $this->published()
            ->where('end_date', '<', date('Y-m-d'))
            ->order();
        if ($number) {
            $query->take($number);
        }

        return $query->get();
    }

    public function adjacent($direction, $model, $category_id = null, array $with = [], $all = false): ?Model
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

                return $models[$adjacentKey] ?? null;
            }
        }

        return null;
    }

    protected function thumb(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->present()->image(null, 54)
        );
    }

    public function image(): BelongsTo
    {
        return $this->belongsTo(File::class, 'image_id');
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    public function ogImage(): BelongsTo
    {
        return $this->belongsTo(File::class, 'og_image_id');
    }
}
