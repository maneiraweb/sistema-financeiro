<?php

namespace SisFin\Transformers;

use League\Fractal\TransformerAbstract;
use SisFin\Models\Categoria;

/**
 * Class CategoriaTransformer
 * @package namespace SisFin\Transformers;
 */
class CategoriaTransformer extends TransformerAbstract
{

    protected $defaultIncludes = ['children'];
    /**
     * Transform the \Categoria entity
     * @param \Categoria $model
     *
     * @return array
     */
    public function transform(Categoria $model)
    {
        return [
            'id'         => (int) $model->id,
            'nome'       => $model->nome,
            'parent_id'  => $model->parent_id,
            'depth'      => $model->depth,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }

    public function includeChildren(Categoria $model) {
        //if($model->children->count()){
            $children = $model->children()->withDepth()->get();
            return $this->collection($children, new CategoriaTransformer());
        //}
    }
}
