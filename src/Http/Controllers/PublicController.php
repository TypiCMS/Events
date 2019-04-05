<?php

namespace TypiCMS\Modules\Events\Http\Controllers;

use TypiCMS;
use TypiCMS\Modules\Core\Http\Controllers\BasePublicController;
use TypiCMS\Modules\Events\Repositories\EloquentEvent;
use TypiCMS\Modules\Events\Services\Calendar;

class PublicController extends BasePublicController
{
    protected $calendar;

    public function __construct(EloquentEvent $event, Calendar $calendar)
    {
        parent::__construct($event);
        $this->calendar = $calendar;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $models = $this->repository->paginateUpcomingEvents(config('typicms.events.per_page'));

        return view('events::public.index')
            ->with(compact('models'));
    }

    /**
     * Display past events paginated.
     *
     * @return \Illuminate\View\View
     */
    public function past()
    {
        $models = $this->repository->paginatePastEvents(config('typicms.events.per_page'));

        return view('events::public.past')
            ->with(compact('models'));
    }

    /**
     * Show event.
     *
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {
        $model = $this->repository->bySlug($slug);

        return view('events::public.show')
            ->with(compact('model'));
    }

    /**
     * Show event.
     *
     * @return \Illuminate\Support\Facades\Response
     */
    public function ics($slug)
    {
        $event = $this->repository->bySlug($slug);

        $this->calendar->add($event);

        $response = response($this->calendar->render(), 200);
        $response->header('Content-Type', 'text/calendar; charset=utf-8');
        $response->header('Content-Disposition', 'attachment; filename="'.$event->slug.'.ics"');

        return $response;
    }
}
