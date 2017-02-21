<?php

namespace SisFin\Transformers;

use League\Fractal\TransformerAbstract;
use SisFin\Models\BillPay;

/**
 * Class BillPayransformer
 * @package namespace SisFin\Transformers;
 */
class BillPayTransformer extends TransformerAbstract
{

    //protected $availableIncludes = ['banco']; 

    public function transform(BillPay $model)
    {
        return [
            'id'         => (int) $model->id,
            'date_due' => $model->date_due,
            'name' => $model->name,
            'value' => (float) $model->value,
            'done' => (boolean) $model->done,
            
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }

    /*public function includeBanco(ContaBancaria $model) {
        return $this->item($model->banco, new BancoTransformer());
    }*/
}
