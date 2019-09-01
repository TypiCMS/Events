<?php

namespace TypiCMS\Modules\Events\Http\Controllers;

use Illuminate\Support\Carbon;
use TypiCMS\Modules\Core\Http\Controllers\BaseAdminController;
use TypiCMS\Modules\Events\Http\Requests\FormRequest;
use TypiCMS\Modules\Events\Models\Event;

class AdminController extends BaseAdminController
{
    /**
     * List models.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $models = $this->model->with('files')->findAll();

        return view('events::admin.index');
    }

    /**
     * Create form for a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $model = new;

        return view('events::admin.create')
            ->with(compact('model'));
    }

    /**
     * Edit form for the specified resource.
     *
     * @param \TypiCMS\Modules\Events\Models\Event $event
     *
     * @return \Illuminate\View\View
     */
    public function edit(Event $event)
    {
        return view('events::admin.edit')
            ->with(['model' => $event]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \TypiCMS\Modules\Events\Http\Requests\FormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(FormRequest $request)
    {
        $data = $request->all();
        $data['start_date'] = Carbon::createFromFormat('Y-m-d\TH:i', $request->start_date);
        $data['end_date'] = Carbon::createFromFormat('Y-m-d\TH:i', $request->end_date);
        $event = ::create($data);

        return $this->redirect($request, $event);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \TypiCMS\Modules\Events\Models\Event              $event
     * @param \TypiCMS\Modules\Events\Http\Requests\FormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Event $event, FormRequest $request)
    {
        $data = $request->all();
        $data['start_date'] = Carbon::createFromFormat('Y-m-d\TH:i', $request->start_date);
        $data['end_date'] = Carbon::createFromFormat('Y-m-d\TH:i', $request->end_date);
        ::update($request->id, $data);

        return $this->redirect($request, $event);
    }
}
