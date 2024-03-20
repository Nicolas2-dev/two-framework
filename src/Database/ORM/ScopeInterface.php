<?php

namespace Two\Database\ORM;


interface ScopeInterface
{
    /**
     * Apply the scope to a given ORM query builder.
     *
     * @param  \Two\Database\ORM\Builder  $builder
     * @return void
     */
    public function apply(Builder $builder);

    /**
     * Remove the scope from the given ORM query builder.
     *
     * @param  \Two\Database\ORM\Builder  $builder
     * @return void
     */
    public function remove(Builder $builder);

}
