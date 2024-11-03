<?php

namespace TypiCMS\Modules\Events\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Laracasts\Presenter\PresentableTrait;
use TypiCMS\Modules\Core\Models\Base;
use TypiCMS\Modules\Core\Traits\Historable;
use TypiCMS\Modules\Events\Presenters\RegistrationPresenter;

class Registration extends Base
{
    use Historable;
    use PresentableTrait;

    protected string $presenter = RegistrationPresenter::class;

    protected $guarded = ['id', 'exit', 'my_name', 'my_time'];

    public function editUrl(): string
    {
        $route = 'admin::edit-' . Str::singular($this->getTable());
        if (Route::has($route)) {
            return route($route, [$this->event_id, $this->id]);
        }

        return route('dashboard');
    }

    public function indexUrl(): string
    {
        $route = 'admin::index-' . $this->getTable();
        if (Route::has($route)) {
            return route($route, $this->event_id);
        }

        return route('dashboard');
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
