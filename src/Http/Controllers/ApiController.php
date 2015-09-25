<?php
namespace TypiCMS\Modules\Events\Http\Controllers;

use TypiCMS\Modules\Core\Http\Controllers\BaseApiController;
use TypiCMS\Modules\Events\Http\Requests\FormRequest;
use TypiCMS\Modules\Events\Repositories\EventInterface as Repository;

class ApiController extends BaseApiController
{
    public function __construct(Repository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  FormRequest $request
     * @return Model|false
     */
    public function store(FormRequest $request)
    {
        $model = $this->repository->create(Input::all());
        $error = $model ? false : true ;
        return response()->json([
            'error' => $error,
            'model' => $model,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  $model
     * @param  FormRequest $request
     * @return boolean
     */
    public function update($model, FormRequest $request)
    {
        $error = $this->repository->update($request->all()) ? false : true ;
        return response()->json([
            'error' => $error,
        ], 200);
    }
}
