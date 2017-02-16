<?php

namespace SisFin\Http\Controllers\Api;

use SisFin\Repositories\CategoryRevenueRepository;
use SisFin\Http\Controllers\Controller;
use SisFin\Criteria\WithDepthCategoriesCriteria;

class CategoryRevenuesController extends Controller {
    use CategoriesControllerTrait;

    protected $repository;

    public function __construct(CategoryRevenueRepository $repository) {
        $this->repository = $repository;
        $this->repository->pushCriteria(new WithDepthCategoriesCriteria());
    }
}