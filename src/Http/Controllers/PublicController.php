<?php
namespace TypiCMS\Modules\Events\Http\Controllers;

use Config;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Support\Str;
use Input;
use Response;
use TypiCMS;
use TypiCMS\Http\Controllers\BasePublicController;
use TypiCMS\Modules\Events\Repositories\EventInterface;
use TypiCMS\Modules\Events\Services\Calendar;
use View;

class PublicController extends BasePublicController
{

    protected $calendar;

    public function __construct(EventInterface $event, Calendar $calendar)
    {
        parent::__construct($event);
        $this->calendar = $calendar;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $page = Input::get('page');
        $perPage = config('typicms.events.per_page');
        $data = $this->repository->byPage($page, $perPage, ['translations']);
        $models = new Paginator($data->items, $data->totalItems, $perPage, null, ['path' => Paginator::resolveCurrentPath()]);

        return view('events::public.index')
            ->with(compact('models'));
    }

    /**
     * Show event.
     *
     * @return Response
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
     * @return Response
     */
    public function ics($slug)
    {
        $event = $this->repository->bySlug($slug);

        $this->calendar->add($event);

        $response = Response::make($this->calendar->render(), 200);
        $response->header('Content-Type', 'text/calendar; charset=utf-8');
        $response->header('Content-Disposition', 'attachment; filename="' . $event->slug . '.ics"');

        return $response;
    }
}
