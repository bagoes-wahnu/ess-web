<?php

namespace App\Helpers;

use Illuminate\Auth\EloquentUserProvider;

class CustomEloquentUserProvider extends EloquentUserProvider
{
    protected function newModelQuery($model = null)
    {
        $modelQuery = parent::newModelQuery();
        return $modelQuery->withoutGlobalScope('isActive');
    }
}