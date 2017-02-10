<?php

namespace SisFin\Repositories;

trait GetClientesTrait{
    
    private function getClientes() {
        $repository = app(\SisFin\Repositories\ClienteRepository::class);
        $repository->skipPresenter(true);
        return $repository->all();
    }
}