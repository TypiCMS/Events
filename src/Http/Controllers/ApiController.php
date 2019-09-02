<?php

namespace TypiCMS\Modules\Events\Http\Controllers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\Filter;
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
            ->allowedFilters([
                Filter::custom('start_date,end_date,title', FilterOr::class),
            ])
            ->allowedIncludes('image')
            ->translated($request->input('translatable_fields'))
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

    public function files(Event $event): Collection
    {
        return $event->files;
    }

    public function attachFiles(Event $event, Request $request): JsonResponse
    {
        return $event->attachFiles($request);
    }

    public function detachFile(Event $event, File $file): array
    {
        return $event->detachFile($file);
    }
}
