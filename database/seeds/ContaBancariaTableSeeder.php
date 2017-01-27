<?php

use Illuminate\Database\Seeder;

class ContaBancariaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $repository = app(\SisFin\Repositories\BancoRepository::class);
        $bancos = $repository->all();
        $max = 15;
        $contaBancariaId = rand(1, $max);

        factory(\SisFin\Models\ContaBancaria::class, $max)
            ->make()
            ->each(function($contaBancaria) use($bancos, $contaBancariaId){
                $banco = $bancos->random();
                $contaBancaria->banco_id = $banco->id;

                $contaBancaria->save();

                if($contaBancariaId == $contaBancaria->id) {
                    $contaBancaria->default = 1;
                    $contaBancaria->save();
                }
            });
    }
}
