<?php

namespace TypiCMS\Modules\Events\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use TypiCMS\Modules\Core\Http\Controllers\BaseAdminController;
use TypiCMS\Modules\Events\Exports\RegistrationsExport;
use TypiCMS\Modules\Events\Http\Requests\RegistrationFormRequest;
use TypiCMS\Modules\Events\Models\Event;
use TypiCMS\Modules\Events\Models\Registration;

class RegistrationsAdminController extends BaseAdminController
{
    public function index(Event $event)
    {
        return view('events::admin.registrations')->with(compact('event'));
    }

    public function export(Request $request, Event $event)
    {
        $filename = 'Registrations-for-'.Str::slug($event->title);
        $filename .= '.xlsx';

        return Excel::download(new RegistrationsExport($request), $filename);
    }

    public function edit(Event $event, Registration $registration)
    {
        $event = $registration->event;

        return view('events::admin.edit-registration')
            ->with(['model' => $registration, 'event' => $event]);
    }

    public function update(Event $event, Registration $registration, RegistrationFormRequest $request)
    {
        $registration->update($request->validated());

        return $this->redirect($request, $registration);
    }
}
