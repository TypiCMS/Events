<?php

namespace TypiCMS\Modules\Events\Repositories;

use Illuminate\Support\Facades\Input;
use TypiCMS\Modules\Core\Repositories\CacheAbstractDecorator;
use TypiCMS\Modules\Core\Services\Cache\CacheInterface;

class CacheDecorator extends CacheAbstractDecorator implements EventInterface
{
    public function __construct(EventInterface $repo, CacheInterface $cache)
    {
        $this->repo = $repo;
        $this->cache = $cache;
    }

    /**
     * Get incomings events.
     *
     * @param int   $number number of items to take
     * @param array $with   array of related items
     *
     * @return Collection
     */
    public function incoming($number = 10, array $with = ['translations'])
    {
        $cacheKey = md5(config('app.locale').'incoming'.$number.implode('.', $with).implode('.', Input::all()));

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        // Item not cached, retrieve it
        $models = $this->repo->incoming($number, $with);

        // Store in cache for next request
        $this->cache->put($cacheKey, $models);

        return $models;
    }
}
