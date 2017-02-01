<?php

namespace SisFin\Presenters;

use SisFin\Transformers\BancoTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class BancoPresenter
 *
 * @package namespace SisFin\Presenters;
 */
class BancoPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new BancoTransformer();
    }
}
