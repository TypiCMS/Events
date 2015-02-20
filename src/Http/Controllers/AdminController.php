<?php
namespace TypiCMS\Modules\Events\Http\Controllers;

use TypiCMS\Http\Controllers\AdminSimpleController;
use TypiCMS\Modules\Events\Http\Requests\FormRequest;
use TypiCMS\Modules\Events\Repositories\EventInterface;

class AdminController extends AdminSimpleController
{

    public function __construct(EventInterface $event)
    {
        parent::__construct($event);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  FormRequest $request
     * @return Redirect
     */
    public function store(FormRequest $request)
    {
        $model = $this->repository->create($request->all());
        return $this->redirect($request, $model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  $model
     * @param  FormRequest $request
     * @return Redirect
     */
    public function update($model, FormRequest $request)
    {
        $this->repository->update($request->all());
        return $this->redirect($request, $model);
    }
}