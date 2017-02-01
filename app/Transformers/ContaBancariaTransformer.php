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

    protected $availableIncludes = ['banco']; 

    public function transform(ContaBancaria $model)
    {
        return [
            'id'         => (int) $model->id,
            'nome' => $model->nome,
            'agencia' => $model->agencia,
            'conta' => $model->conta,
            'default' => (bool) $model->default,
            'banco_id' => (int) $model->banco_id,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }

    public function includeBanco(ContaBancaria $model) {
        return $this->item($model->banco, new BancoTransformer());
    }
}
