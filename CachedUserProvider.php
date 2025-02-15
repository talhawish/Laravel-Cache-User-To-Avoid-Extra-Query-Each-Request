<?php

namespace App\Providers;

use Illuminate\Auth\EloquentUserProvider;

class CachedUserProvider extends EloquentUserProvider
{
    public function retrieveById($id)
    {
        $cacheKey = 'user_' . $id;
        return cache()->remember($cacheKey, 180, fn () => parent::retrieveById($id));
    }
}
