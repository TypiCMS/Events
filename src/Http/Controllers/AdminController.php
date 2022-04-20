<?php

namespace TypiCMS\Modules\Events\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use TypiCMS\Modules\Core\Http\Controllers\BaseAdminController;
use TypiCMS\Modules\Events\Exports\Export;
use TypiCMS\Modules\Events\Http\Requests\FormRequest;
use TypiCMS\Modules\Events\Models\Event;

class AdminController extends BaseAdminController
{
    public function index(): View
    {
        return view('events::admin.index');
    }

    public function export(Request $request)
    {
        $filename = date('Y-m-d').' '.config('app.name').' events.xlsx';

        return Excel::download(new Export(), $filename);
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
        $event = Event::create($request->validated());

        return $this->redirect($request, $event)
            ->withMessage(__('Item successfully created.'));
    }

    public function update(Event $event, FormRequest $request): RedirectResponse
    {
        $event->update($request->validated());

        return $this->redirect($request, $event)
            ->withMessage(__('Item successfully updated.'));
    }
}
