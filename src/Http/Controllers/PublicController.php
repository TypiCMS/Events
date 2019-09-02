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
        $query = Event::with('image');
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
        $query = Event::with('image');
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
        $model = Event::with([
                'image',
                'images',
                'documents',
            ])
            ->where(column('slug'), $slug)->firstOrFail();

        return view('events::public.show')
            ->with(compact('model'));
    }

    public function ics($slug): Response
    {
        $event = Event::where('slug', $slug)->firstOrFail();

        $this->calendar->add($event);

        $response = response($this->calendar->render(), 200);
        $response->header('Content-Type', 'text/calendar; charset=utf-8');
        $response->header('Content-Disposition', 'attachment; filename="'.$event->slug.'.ics"');

        return $response;
    }
}
