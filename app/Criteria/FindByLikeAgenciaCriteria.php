<?php

namespace SisFin\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class FindByLikeAgenciaCriteria
 * @package namespace SisFin\Criteria;
 */
class FindByLikeAgenciaCriteria implements CriteriaInterface
{
    public function __construct($agencia) {
        $this->agencia = $agencia;
    }
    /**
     * Apply criteria in query repository
     *
     * @param                     $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where('agencia', 'LIKE', "%{$this->agencia}%");
    }
}
