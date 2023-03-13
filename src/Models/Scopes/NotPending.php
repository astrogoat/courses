<?php

namespace Astrogoat\Courses\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class NotPending implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        $builder->whereNull('pending_at');
    }
}
