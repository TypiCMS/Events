<?php

namespace TypiCMS\Modules\Events\Repositories;

use Illuminate\Database\Eloquent\Collection;
use TypiCMS\Modules\Core\EloquentRepository;
use TypiCMS\Modules\Events\Models\Event;

class EloquentEvent extends EloquentRepository
{
    protected $repositoryId = 'events';

    protected $model = Event::class;

    /**
     * Get incomings events.
     *
     * @param int   $number number of items to take
     * @param array $with   array of related items
     *
     * @return Collection
     */
    public function incoming($number = null, array $with = ['translations'])
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
