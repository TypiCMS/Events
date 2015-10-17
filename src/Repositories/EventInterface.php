<?php

namespace TypiCMS\Modules\Events\Repositories;

use Illuminate\Database\Eloquent\Collection;
use TypiCMS\Modules\Core\Repositories\RepositoryInterface;

interface EventInterface extends RepositoryInterface
{
    /**
     * Get incomings events.
     *
     * @param int   $number number of items to take
     * @param array $with   array of related items
     *
     * @return Collection
     */
    public function incoming($number = 10, array $with = ['translations']);
}
