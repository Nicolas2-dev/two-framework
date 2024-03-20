<?php

namespace Two\Foundation\Support\Providers;

use Two\Auth\Access\GateInterface as GateContract;
use Two\Support\ServiceProvider;


class AuthServiceProvider extends ServiceProvider
{
    
    /**
     * Les mappages de stratégie pour l'application.
     *
     * @var array
     */
    protected $policies = array();

    
    /**
     * Enregistrez les stratégies de l'application.
     *
     * @param  \Two\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function registerPolicies(GateContract $gate)
    {
        foreach ($this->policies as $key => $value) {
            $gate->policy($key, $value);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        //
    }
}
