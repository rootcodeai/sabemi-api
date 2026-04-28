<?php

namespace App\Support\Traits;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

trait ClearsCacheOnChanges
{
    /**
     * Invalidate cache based on rules.
     */
    public function invalidateCache(): void
    {
        $rules = $this->getCacheInvalidationRules();

        foreach ($rules as $column => $tags) {
            $value = $this->getAttribute($column);

            if ($value) {
                foreach ($tags as $tagPrefix) {
                    // Tag format: prefix:{value}
                    // Example: users:{id} or companies:{company_id}
                    $tag = "{$tagPrefix}:{$value}";
                    try {
                        Cache::tags([$tag])->flush();
                    } catch (\Exception $e) {
                         Log::warning("Could not flush cache tag: {$tag}. Error: " . $e->getMessage());
                    }
                }
            }
        }

        // Also clear base tag if method exists (for list caching)
        if (method_exists($this, 'getCacheTag')) {
            try {
                Cache::tags([$this->getCacheTag()])->flush();
            } catch (\Exception $e) {
                Log::warning("Could not flush base cache tag. Error: " . $e->getMessage());
            }
        }
    }

    /**
     * Get the cache invalidation rules for the model.
     * Returns an array mapping foreign keys (or attributes) to cache tag prefixes.
     *
     * @return array<string, array<string>>
     */
    abstract public function getCacheInvalidationRules(): array;
}
