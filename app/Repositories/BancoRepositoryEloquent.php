<?php

namespace SisFin\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use SisFin\Models\Banco;
use SisFin\Presenters\BancoPresenter;

use SisFin\Events\BancoStoredEvent;
use Illuminate\Http\UploadedFile;

/**
 * Class BancoRepositoryEloquent
 * @package namespace SisFin\Repositories;
 */
class BancoRepositoryEloquent extends BaseRepository implements BancoRepository
{
    public function create(array $attributes) {
        $logo = $attributes['logo'];
        $attributes['logo'] = env('BANCO_LOGO_DEFAULT');
        $skipPresenter = $this->skipPresenter;
        $this->skipPresenter(true);
        $model = parent::create($attributes);
        $event = new BancoStoredEvent($model, $logo);
        event($event);
        $this->skipPresenter = $skipPresenter;

        return $this->parserResult($model);
    }

    public function update(array $attributes, $id) {
        $logo = null;
        if(isset($attributes['logo']) && $attributes['logo'] instanceof UploadedFile){
            $logo = $attributes['logo'];
            unset($attributes['logo']);
        }

        $skipPresenter = $this->skipPresenter;
        $this->skipPresenter(true);
        $model = parent::update($attributes, $id);
        $event = new BancoStoredEvent($model, $logo);
        event($event);
        $this->skipPresenter = $skipPresenter;

        return $this->parserResult($model);
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

    public function presenter() {
        return BancoPresenter::class;
    }
}
