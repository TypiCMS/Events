<?php

namespace TypiCMS\Modules\Events\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\View\View;
use TypiCMS;
use TypiCMS\Modules\Core\Http\Controllers\BasePublicController;
use TypiCMS\Modules\Events\Models\Event;
use TypiCMS\Modules\Events\Services\Calendar;

class PublicController extends BasePublicController
{
    protected $calendar;

    public function __construct(Calendar $calendar)
    {
        $this->calendar = $calendar;
    }

    public function index(): View
    {
        $query = Event::published()
            ->order()
            ->with('image');
        if (!request('preview')) {
            $query->published();
        }
        $models = $query->orderBy('start_date')
            ->where('end_date', '>=', date('Y-m-d'))
            ->paginate(config('typicms.events.per_page'));

        return view('events::public.index')
            ->with(compact('models'));
    }

    public function past(): View
    {
        $query = Event::published()->with('image');
        if (!request('preview')) {
            $query->published();
        }
        $models = $query->order()
            ->where('end_date', '<', date('Y-m-d'))
            ->paginate(config('typicms.events.per_page'));

        return view('events::public.past')
            ->with(compact('models'));
    }

    public function show($slug): View
    {
        $model = Event::published()
            ->with([
                'image',
                'images',
                'documents',
            ])
            ->whereSlugIs($slug)
            ->firstOrFail();

        return view('events::public.show')
            ->with(compact('model'));
    }

    public function ics($slug): Response
    {
        $event = Event::published()
            ->whereSlugIs($slug)
            ->firstOrFail();

        $this->calendar->add($event);

        $response = response($this->calendar->render(), 200);
        $response->header('Content-Type', 'text/calendar; charset=utf-8');
        $response->header('Content-Disposition', 'attachment; filename="'.$event->slug.'.ics"');

        return $response;
    }
}
