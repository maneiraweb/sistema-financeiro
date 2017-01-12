<?php

namespace SisFin\Listeners;

use SisFin\Repositories\BancoRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use SisFin\Models\Banco;
use SisFin\Events\BancoStoredEvent;

class BancoLogoUploadListener
{
    private $repository;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(BancoRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Handle the event.
     *
     * @param  BancoStoredEvent  $event
     * @return void
     */
    public function handle(BancoStoredEvent $event)
    {
        $banco = $event->getBanco();
        $logo = $event->getLogo();

        if($logo) {

            $nome = $banco->created_at != $banco->updated_at ? $banco->logo : md5(time().$logo->getClientOriginalName()) . '.' . $logo->guessExtension();
            $destFile = Banco::logosDir();

            $result = \Storage::disk('public')->putFileAs($destFile, $logo, $nome);

            if($result && $banco->created_at == $banco->updated_at){
                $this->repository->update(['logo' => $nome], $banco->id);
            }
        }
    }
}
