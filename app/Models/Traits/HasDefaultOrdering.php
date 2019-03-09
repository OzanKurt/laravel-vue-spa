<?php

namespace App\Models\Traits;

use App\Models\Scopes\OrderScope;

/**
 * Trait HasDefaultOrdering
 * @package App\Models\Traits
 */
trait HasDefaultOrdering
{

    /**
     * Boot the user stamps trait for a model.
     *
     * @return void
     */
    public static function bootHasDefaultOrdering()
    {
        static::addGlobalScope(
            new OrderScope(self::$ordering)
        );
    }
}
