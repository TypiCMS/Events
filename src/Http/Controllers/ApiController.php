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

    protected function updatePartial(Event $event, Request $request): JsonResponse
    {
        $data = [];
        foreach ($request->all() as $column => $content) {
            if (is_array($content)) {
                foreach ($content as $key => $value) {
                    $data[$column.'->'.$key] = $value;
                }
            } else {
                $data[$column] = $content;
            }
        }

        foreach ($data as $key => $value) {
            $event->$key = $value;
        }
        $saved = $event->save();

        return response()->json([
            'error' => !$saved,
        ]);
    }

    public function destroy(Event $event): JsonResponse
    {
        $deleted = $event->delete();

        return response()->json([
            'error' => !$deleted,
        ]);
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
