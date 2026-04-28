<?php

namespace App\Repositories;

use Illuminate\Cache\Repository as CacheRepository;
use Closure;

abstract class BaseCachingRepository
{
    protected CacheRepository $cache;

    public function __construct(CacheRepository $cache)
    {
        $this->cache = $cache;
    }

    /**
     * Remember a value in cache with tags.
     *
     * @param string $key
     * @param int $ttl Minutes
     * @param array $tags
     * @param Closure $callback
     * @return mixed
     */
    protected function remember(string $key, int $ttl, array $tags, Closure $callback): mixed
    {
        return $this->cache->tags($tags)->remember($key, $ttl * 60, $callback);
    }
}
