<?php

namespace TypiCMS\Modules\Events\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Laracasts\Presenter\PresentableTrait;
use TypiCMS\Modules\Core\Models\Base;
use TypiCMS\Modules\Core\Models\History;
use TypiCMS\Modules\Core\Traits\Historable;
use TypiCMS\Modules\Events\Presenters\RegistrationPresenter;

/**
 * @property int $id
 * @property int $event_id
 * @property int|null $user_id
 * @property int $number_of_people
 * @property string|null $email
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $locale
 * @property string|null $message
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Event $event
 * @property-read Collection<int, History> $history
 * @property-read int|null $history_count
 * @property-write mixed $status
 */
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

    /** @return BelongsTo<Event, $this> */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
