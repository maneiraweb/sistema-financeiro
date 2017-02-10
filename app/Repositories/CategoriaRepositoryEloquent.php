<?php

namespace SisFin\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use SisFin\Repositories\CategoriaRepository;
use SisFin\Models\Categoria;
use SisFin\Validators\CategoriaValidator;
use SisFin\Presenters\CategoriaPresenter;

/**
 * Class CategoriaRepositoryEloquent
 * @package namespace SisFin\Repositories;
 */
class CategoriaRepositoryEloquent extends BaseRepository implements CategoriaRepository
{

    public function create(array $attributes) {
        if(isset($attributes['parent_id'])){
            //filho
            $skipPresenter = $this->skipPresenter;
            $this->skipPresenter(true);
            $parent = $this->find($attributes['parent_id']);
            $this->skipPresenter = $skipPresenter;
            $child = $parent->children()->create($attributes);
            return $this->parserResult($child);
        } else {
            //pai
            return parent::create($attributes);
        }
    }

    public function update(array $attributes, $id) {
        if(isset($attributes['parent_id'])){
            //filho
            $skipPresenter = $this->skipPresenter;
            $this->skipPresenter(true);
            $child = $this->find($id);
            $child->parent_id = $attributes['parent_id'];
            $child->save();
            $this->skipPresenter = $skipPresenter;
            return $this->parserResult($child);
        } else {
            //pai
            return parent::update($attributes, $id);
        }
    }
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Categoria::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function presenter() {
        return CategoriaPresenter::class;
    }
}
