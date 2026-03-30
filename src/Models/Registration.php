<?php

declare(strict_types=1);

namespace TypiCMS\Modules\Events\Models;

use Illuminate\Database\Eloquent\Attributes\Unguarded;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use TypiCMS\Modules\Core\Models\History;
use TypiCMS\Modules\Core\Traits\HasConfigurableOrder;
use TypiCMS\Modules\Core\Traits\HasContentPresenter;
use TypiCMS\Modules\Core\Traits\HasSelectableFields;
use TypiCMS\Modules\Core\Traits\HasSlugScope;
use TypiCMS\Modules\Core\Traits\Historable;
use TypiCMS\Modules\Events\Models\Event as EventModel;

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
 * @property-read EventModel $event
 * @property-read Collection<int, History> $history
 * @property-read int|null $history_count
 * @property-write mixed $status
 */
#[Unguarded]
class Registration extends Model
{
    use HasConfigurableOrder;
    use HasContentPresenter;
    use HasSelectableFields;
    use HasSlugScope;
    use Historable;

    public function editUrl(): string
    {
        $route = 'admin::edit-'.Str::singular($this->getTable());
        if (Route::has($route)) {
            return route($route, [$this->event_id, $this->id]);
        }

        return route('dashboard');
    }

    public function indexUrl(): string
    {
        $route = 'admin::index-'.$this->getTable();
        if (Route::has($route)) {
            return route($route, $this->event_id);
        }

        return route('dashboard');
    }

    public function presentTitle(): string
    {
        return __('Reservation of').' '.$this->first_name.' '.$this->last_name;
    }

    /** @return BelongsTo<EventModel, $this> */
    public function event(): BelongsTo
    {
        return $this->belongsTo(EventModel::class);
    }
}
