<?php

namespace Two\Contracts;


interface ArrayableInterface
{
    
    /**
     * Obtenez l'instance sous forme de tableau.
     *
     * @return array
     */
    public function toArray();
}
