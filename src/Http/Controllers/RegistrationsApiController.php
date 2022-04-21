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
        $data = QueryBuilder::for(Registration::class)
            ->selectFields($request->input('fields.registrations'))
            ->allowedSorts(['created_at', 'first_name', 'last_name', 'email', 'locale', 'number_of_people', 'message'])
            ->where('event_id', $event->id)
            ->allowedFilters([
                AllowedFilter::custom('created_at,first_name,last_name,email,locale,number_of_people,message', new FilterRegistrations()),
            ])
            ->paginate($request->input('per_page'));

        return $data;
    }

    public function destroy(Event $event, Registration $registration)
    {
        $registration->delete();
        (new Event())->flushCache();
    }
}
