<?php

namespace TypiCMS\Modules\Events\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\Paginator;
use TypiCMS\Modules\Core\Repositories\EloquentRepository;
use TypiCMS\Modules\Events\Models\Event;

class EloquentEvent extends EloquentRepository
{
    protected $repositoryId = 'events';

    protected $model = Event::class;

    /**
     * Get incomings events.
     *
     * @param int $number number of items to take
     *
     * @return Collection
     */
    public function upcoming($number = null)
    {
        return $this->published()->executeCallback(static::class, __FUNCTION__, func_get_args(), function () use ($number) {
            $query = $this->prepareQuery($this->createModel())
                ->where('end_date', '>=', date('Y-m-d'))
                ->orderBy('start_date');
            if ($number) {
                $query->take($number);
            }

            return $query->get();
        });
    }

    public function paginateUpcomingEvents($perPage = null, $attributes = ['*'], $pageName = 'page', $page = null)
    {
        $page = $page ?: Paginator::resolveCurrentPage($pageName);
        if (!request('preview')) {
            $this->published();
        }

        return $this->executeCallback(static::class, __FUNCTION__, array_merge(func_get_args(), compact('page')), function () use ($perPage, $attributes, $pageName, $page) {
            return $this->prepareQuery($this->createModel())
                ->orderBy('start_date')
                ->where('end_date', '>=', date('Y-m-d'))
                ->paginate($perPage, $attributes, $pageName, $page);
        });
    }

    public function paginatePastEvents($perPage = null, $attributes = ['*'], $pageName = 'page', $page = null)
    {
        $page = $page ?: Paginator::resolveCurrentPage($pageName);
        if (!request('preview')) {
            $this->published();
        }

        return $this->executeCallback(static::class, __FUNCTION__, array_merge(func_get_args(), compact('page')), function () use ($perPage, $attributes, $pageName, $page) {
            return $this->prepareQuery($this->createModel())
                ->order()
                ->where('end_date', '<', date('Y-m-d'))
                ->paginate($perPage, $attributes, $pageName, $page);
        });
    }

    public function adjacent($direction, $model, $category_id = null, array $with = [], $all = false)
    {
        $currentModel = $model;
        $models = $this->upcoming();
        foreach ($models as $key => $model) {
            if ($currentModel->id === $model->id) {
                $adjacentKey = $key + $direction;

                return isset($models[$adjacentKey]) ? $models[$adjacentKey] : null;
            }
        }
    }
}
