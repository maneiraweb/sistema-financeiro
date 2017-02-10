<?php

namespace SisFin\Presenters;

use SisFin\Transformers\CategoriaTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class CategoriaPresenter
 *
 * @package namespace SisFin\Presenters;
 */
class CategoriaPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new CategoriaTransformer();
    }
}
