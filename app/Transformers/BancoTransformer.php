<?php

namespace SisFin\Transformers;

use League\Fractal\TransformerAbstract;
use SisFin\Models\Banco;

/**
 * Class BancoTransformer
 * @package namespace SisFin\Transformers;
 */
class BancoTransformer extends TransformerAbstract
{

    /**
     * Transform the \Banco entity
     * @param \Banco $model
     *
     * @return array
     */
    public function transform(Banco $model)
    {
        return [
            'id'         => (int) $model->id,
            'nome'  => $model->nome,
            'logo'  => $this->makeLogoPath($model),

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }

    public function makeLogoPath(Banco $model) {
        $url = url('/');
        $folder = Banco::logosDir();
        return "$url/storage/$folder/{$model->logo}";
    }
}
