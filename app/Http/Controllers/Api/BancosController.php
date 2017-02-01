<?php

namespace SisFin\Http\Controllers\Api;

use SisFin\Repositories\BancoRepository;
use SisFin\Http\Controllers\Controller;

use SisFin\Http\Requests;

class BancosController extends Controller
{
    private $repository;

    public function __construct(BancoRepository $repository) {
        $this->repository = $repository;
    }

    public function index() {
        return $this->repository->all();
    }
}
