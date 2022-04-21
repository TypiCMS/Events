<?php

namespace TypiCMS\Modules\Events\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use TypiCMS\Modules\Core\Filters\FilterOr;
use TypiCMS\Modules\Core\Http\Controllers\BaseApiController;
use TypiCMS\Modules\Events\Models\Event;

class ApiController extends BaseApiController
{
    public function index(Request $request): LengthAwarePaginator
    {
        $data = QueryBuilder::for(Event::class)
            ->selectFields($request->input('fields.events'))
            ->allowedSorts(['status_translated', 'start_date', 'end_date', 'title_translated'])
            ->allowedFilters([
                AllowedFilter::custom('title', new FilterOr()),
            ])
            ->addSelect([
                'registration_count' => DB::table('registrations')->selectRaw('COUNT(*)')->whereColumn('events.id', 'registrations.event_id'),
            ])
            ->allowedIncludes(['image'])
            ->paginate($request->input('per_page'));

        return $data;
    }

    protected function updatePartial(Event $event, Request $request)
    {
        foreach ($request->only('status') as $key => $content) {
            if ($event->isTranslatableAttribute($key)) {
                foreach ($content as $lang => $value) {
                    $event->setTranslation($key, $lang, $value);
                }
            } else {
                $event->{$key} = $content;
            }
        }

        $event->save();
    }

    public function destroy(Event $event)
    {
        $event->delete();
    }
}
