<?php

namespace SisFin\Events;

use SisFin\Models\Banco;
use Illuminate\Http\UploadedFile;

class BancoStoredEvent
{
    private $banco;

    private $logo;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Banco $banco, UploadedFile $logo = null)
    {
        $this->banco = $banco;
        $this->logo = $logo;
    }

    public function getBanco() {
        return $this->banco;
    }

    public function getLogo() {
        return $this->logo;
    }
}
