<?php

namespace Two\Contracts;


interface RenderableInterface
{
    
    /**
     * Obtenez le contenu évalué de l'objet.
     *
     * @return string
     */
    public function render();
}
