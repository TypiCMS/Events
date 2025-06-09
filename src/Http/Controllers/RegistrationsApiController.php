<?php

namespace TypiCMS\Modules\Events\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use TypiCMS\Modules\Core\Http\Controllers\BaseApiController;
use TypiCMS\Modules\Events\Filters\FilterRegistrations;
use TypiCMS\Modules\Events\Models\Event;
use TypiCMS\Modules\Events\Models\Registration;

class RegistrationsApiController extends BaseApiController
{
    public function index(Request $request, Event $event)
    {
        $query = Registration::query()->selectFields()
            ->where('event_id', $event->id);
        $data = QueryBuilder::for($query)
            ->allowedSorts(['created_at', 'first_name', 'last_name', 'email', 'locale', 'number_of_people', 'message'])
            ->allowedFilters([
                AllowedFilter::custom('created_at,first_name,last_name,email,locale,number_of_people,message', new FilterRegistrations()),
            ])
            ->paginate($request->integer('per_page'));

        return $data;
    }

    public function destroy(Event $event, Registration $registration)
    {
        $registration->delete();
        (new Event())->flushCache();
    }
}
