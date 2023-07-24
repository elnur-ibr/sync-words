<?php

namespace App\Models\Scopes;

use App\Models\Event;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class AuthorizationScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  Builder  $builder
     * @param  Model|Event  $model
     */
    public function apply(Builder|Event $builder, Model $model): void
    {
        $builder->whereRelation('users', 'users.id', auth()->id());
    }
}
