<?php

namespace SisFin\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use SisFin\Models\Banco;

use SisFin\Events\BancoStoredEvent;

/**
 * Class BancoRepositoryEloquent
 * @package namespace SisFin\Repositories;
 */
class BancoRepositoryEloquent extends BaseRepository implements BancoRepository
{
    public function create(array $attributes) {
        $logo = $attributes['logo'];
        $attributes['logo'] = "semimagem.jpg";
        $model =  parent::create($attributes);
        $event = new BancoStoredEvent($model, $logo);
        event($event);

        return $model;
    }

    public function update(array $attributes, $id) {
        $logo = null;
        if(isset($attributes['logo'])){
            $logo = $attributes['logo'];
            unset($attributes['logo']);
        }
        $model =  parent::update($attributes, $id);
        $event = new BancoStoredEvent($model, $logo);
        event($event);

        return $model;
    }

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
