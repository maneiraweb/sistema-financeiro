<?php

namespace SisFin\Http\Controllers\Api;

use SisFin\Repositories\CategoryExpenseRepository;
use SisFin\Http\Controllers\Controller;
use SisFin\Criteria\WithDepthCategoriesCriteria;

class CategoryExpensesController extends Controller {
    use CategoriesControllerTrait;

    protected $repository;

    public function __construct(CategoryExpenseRepository $repository) {
        $this->repository = $repository;
        $this->repository->pushCriteria(new WithDepthCategoriesCriteria());
    }
}