<?php

namespace TypiCMS\Modules\Events\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;
use Illuminate\View\View;
use TypiCMS\Modules\Core\Http\Controllers\BaseAdminController;
use TypiCMS\Modules\Events\Http\Requests\FormRequest;
use TypiCMS\Modules\Events\Models\Event;

class AdminController extends BaseAdminController
{
    public function index(): View
    {
        return view('events::admin.index');
    }

    public function create(): View
    {
        $model = new Event();

        return view('events::admin.create')
            ->with(compact('model'));
    }

    public function edit(Event $event): View
    {
        return view('events::admin.edit')
            ->with(['model' => $event]);
    }

    public function store(FormRequest $request): RedirectResponse
    {
        $data = $request->all();
        $data['start_date'] = Carbon::createFromFormat('Y-m-d\TH:i', $request->start_date);
        $data['end_date'] = Carbon::createFromFormat('Y-m-d\TH:i', $request->end_date);
        $event = Event::create($data);

        return $this->redirect($request, $event);
    }

    public function update(Event $event, FormRequest $request): RedirectResponse
    {
        $data = $request->all();
        $data['start_date'] = Carbon::createFromFormat('Y-m-d\TH:i', $request->start_date);
        $data['end_date'] = Carbon::createFromFormat('Y-m-d\TH:i', $request->end_date);
        $event->update($data);

        return $this->redirect($request, $event);
    }
}
