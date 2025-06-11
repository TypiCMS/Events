<?php

namespace TypiCMS\Modules\Events\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Notification;
use Illuminate\View\View;
use TypiCMS\Modules\Core\Http\Controllers\BasePublicController;
use TypiCMS\Modules\Events\Http\Requests\RegistrationFormRequest;
use TypiCMS\Modules\Events\Models\Event;
use TypiCMS\Modules\Events\Models\Registration;
use TypiCMS\Modules\Events\Notifications\NewRegistrationToAnEvent;
use TypiCMS\Modules\Events\Notifications\RegisteredToEvent;
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
        $models = Event::query()
            ->published()
            ->with('image')
            ->orderBy('start_date')
            ->where('end_date', '>=', date('Y-m-d'))
            ->paginate(config('typicms.modules.events.per_page'));

        return view('events::public.index')
            ->with(compact('models'));
    }

    public function past(): View
    {
        $models = Event::query()
            ->published()
            ->with('image')
            ->orderBy('end_date', 'desc')
            ->where('end_date', '<', date('Y-m-d'))
            ->paginate(config('typicms.modules.events.per_page'));

        return view('events::public.past')
            ->with(compact('models'));
    }

    public function show(string $slug): View
    {
        $model = Event::query()
            ->published()
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

    public function showRegistrationForm(string $slug): View
    {
        $event = Event::query()
            ->published()
            ->whereSlugIs($slug)
            ->firstOrFail();
        if (!$event->registration_form || $event->end_date < date('Y-m-d')) {
            abort(404);
        }

        return view('events::public.registration')
            ->with(compact('event'));
    }

    public function register(string $slug, RegistrationFormRequest $request): RedirectResponse
    {
        $event = Event::query()
            ->published()
            ->whereSlugIs($slug)
            ->firstOrFail();
        if (!$event->registration_form || $event->end_date < date('Y-m-d')) {
            abort(404);
        }
        $user = auth()->user();
        $data = $request->validated();
        $data['user_id'] = $user->id;
        $data['event_id'] = $event->id;
        $data['first_name'] = $user->first_name;
        $data['last_name'] = $user->last_name;
        $data['email'] = $user->email;
        $data['locale'] = $user->locale;

        $registration = Registration::create($data);
        (new Event())->flushCache();

        Notification::route('mail', config('typicms.webmaster_email'))
            ->notify(new NewRegistrationToAnEvent($event, $registration));

        Notification::route('mail', $data['email'])
            ->notify(new RegisteredToEvent($event, $registration));

        return redirect()->route(app()->getLocale() . '::event-registered', $event->slug)
            ->with('success', true);
    }

    public function registered(string $slug): RedirectResponse
    {
        $event = Event::query()
            ->published()
            ->whereSlugIs($slug)
            ->firstOrFail();
        if (session('success')) {
            return view('events::public.registered')->with(compact('event'));
        }

        return redirect(url('/'));
    }

    public function ics(string $slug): Response
    {
        $event = Event::query()
            ->published()
            ->whereSlugIs($slug)
            ->firstOrFail();

        $this->calendar->add($event);

        $response = response($this->calendar->render(), 200);
        $response->header('Content-Type', 'text/calendar; charset=utf-8');
        $response->header('Content-Disposition', 'attachment; filename="' . $event->slug . '.ics"');

        return $response;
    }
}
