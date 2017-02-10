<?php

namespace SisFin\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use SisFin\Repositories\ClienteRepository;
use SisFin\Models\Cliente;
use SisFin\Validators\ClienteValidator;

/**
 * Class ClienteRepositoryEloquent
 * @package namespace SisFin\Repositories;
 */
class ClienteRepositoryEloquent extends BaseRepository implements ClienteRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Cliente::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
