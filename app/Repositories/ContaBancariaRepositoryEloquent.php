<?php

namespace SisFin\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use SisFin\Models\ContaBancaria;
use SisFin\Presenters\ContaBancariaPresenter;

/**
 * Class ContaBancariaRepositoryEloquent
 * @package namespace SisFin\Repositories;
 */
class ContaBancariaRepositoryEloquent extends BaseRepository implements ContaBancariaRepository
{
    protected $fieldSearchable = [
        'id' => 'like',
        'nome' => 'like',
        'agencia' => 'like',
        'conta' => 'like',
        'banco.nome' => 'like'
    ];
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ContaBancaria::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function presenter() {
        return ContaBancariaPresenter::class;
    }
}
