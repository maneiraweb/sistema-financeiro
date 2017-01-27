<?php

namespace SisFin\Presenters;

use SisFin\Transformers\ContaBancariaTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ContaBancariaPresenter
 *
 * @package namespace SisFin\Presenters;
 */
class ContaBancariaPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ContaBancariaTransformer();
    }
}
