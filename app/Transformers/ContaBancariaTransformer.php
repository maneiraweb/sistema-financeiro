<?php

namespace SisFin\Transformers;

use League\Fractal\TransformerAbstract;
use SisFin\Models\ContaBancaria;

/**
 * Class ContaBancariaTransformer
 * @package namespace SisFin\Transformers;
 */
class ContaBancariaTransformer extends TransformerAbstract
{

    /**
     * Transform the \ContaBancaria entity
     * @param \ContaBancaria $model
     *
     * @return array
     */
    public function transform(ContaBancaria $model)
    {
        return [
            'id'         => (int) $model->id,
            'nome' => $model->nome,
            'agencia' => $model->agencia,
            'conta' => $model->conta,
            'default' => (bool) $model->default,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
