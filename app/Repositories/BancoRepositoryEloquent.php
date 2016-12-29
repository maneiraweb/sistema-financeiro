<?php

namespace SisFin\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use SisFin\Repositories\BancoRepository;
use SisFin\Models\Banco;
use SisFin\Validators\BancoValidator;

/**
 * Class BancoRepositoryEloquent
 * @package namespace SisFin\Repositories;
 */
class BancoRepositoryEloquent extends BaseRepository implements BancoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Banco::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
