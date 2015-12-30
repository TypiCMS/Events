<?php

namespace TypiCMS\Modules\Events\Http\Controllers;

use TypiCMS\Modules\Core\Http\Controllers\BaseAdminController;
use TypiCMS\Modules\Events\Http\Requests\FormRequest;
use TypiCMS\Modules\Events\Models\Event;
use TypiCMS\Modules\Events\Repositories\EventInterface;

class AdminController extends BaseAdminController
{
    public function __construct(EventInterface $event)
    {
        parent::__construct($event);
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
        $event = $this->repository->create($request->all());

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
        $this->repository->update($request->all());

        return $this->redirect($request, $event);
    }
}
