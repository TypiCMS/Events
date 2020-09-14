<?php

namespace TypiCMS\Modules\Events\Http\Controllers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use TypiCMS\Modules\Core\Filters\FilterOr;
use TypiCMS\Modules\Core\Http\Controllers\BaseApiController;
use TypiCMS\Modules\Events\Models\Event;
use TypiCMS\Modules\Files\Models\File;

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

    /**
     * @deprecated
     */
    public function files(Event $event): Collection
    {
        return $event->files;
    }

    /**
     * @deprecated
     */
    public function attachFiles(Event $event, Request $request): JsonResponse
    {
        return $event->attachFiles($request);
    }

    /**
     * @deprecated
     */
    public function detachFile(Event $event, File $file): void
    {
        $event->detachFile($file);
    }
}
