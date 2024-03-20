<?php

namespace Two\Contracts;


interface MessageProviderInterface
{
    
    /**
     * Obtenez les messages pour l'instance.
     *
     * @return \Two\Support\MessageBag
     */
    public function getMessageBag();
}
