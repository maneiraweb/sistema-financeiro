<?php

use Illuminate\Database\Seeder;

class ContaBancariaTableSeeder extends Seeder
{

    use \SisFin\Repositories\GetClientesTrait;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bancos = $this->getBancos();
        $clientes = $this->getClientes();
        $max = 500;
        $contaBancariaId = rand(1, $max);

        factory(\SisFin\Models\ContaBancaria::class, $max)
            ->make()
            ->each(function($contaBancaria) use($bancos, $clientes, $contaBancariaId){
                $banco = $bancos->random();
                $cliente = $clientes->random();

                $contaBancaria->banco_id = $banco->id;
                $contaBancaria->cliente_id = $cliente->id;

                $contaBancaria->save();

                if($contaBancariaId == $contaBancaria->id) {
                    $contaBancaria->default = 1;
                    $contaBancaria->save();
                }
            });
    }

    private function getBancos() {
        $repository = app(\SisFin\Repositories\BancoRepository::class);
        $repository->skipPresenter(true);
        return $repository->all();
    }
}
