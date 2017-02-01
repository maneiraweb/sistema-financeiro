<?php

namespace SisFin\Listeners;
use SisFin\Repositories\ContaBancariaRepository;
use Prettus\Repository\Events\RepositoryEventBase;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContaBancariaSetDefaultListener
{
    private $repository;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(ContaBancariaRepository $repository)
    {
        $this->repository = $repository;
        $this->repository->skipPresenter(true);
    }

    /**
     * Handle the event.
     *
     * @param  RepositoryBase  $event
     * @return void
     */
    public function handle(RepositoryEventBase $event)
    {
        $model = $event->getModel();
        if(!$model->default){
            return;
        }

        $collection = $this->repository
            ->findByField('default', true)
            ->filter(function($value, $key) use($model){
                return $model->id != $value->id;
            });
        $contaBancariaDefault = $collection->first();
        if($contaBancariaDefault){
            $this->repository->update(['default' => false], $contaBancariaDefault->id);
        }
    }
}
