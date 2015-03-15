<?php
namespace TypiCMS\Modules\Events\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use TypiCMS\Repositories\RepositoriesAbstract;

class EloquentEvent extends RepositoriesAbstract implements EventInterface
{

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get incomings events
     *
     * @param  integer      $number number of items to take
     * @param  array        $with array of related items
     * @return Collection
     */
    public function incoming($number = null, array $with = array('translations'))
    {
        $query = $this->make($with);
        $query->where('end_date', '>=', date('Y-m-d'))
            ->online()
            ->orderBy('start_date');
        if ($number) {
            $query->take($number);
        }
        return $query->get();
    }
}
