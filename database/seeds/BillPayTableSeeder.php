<?php

use Illuminate\Database\Seeder;

class BillPayTableSeeder extends Seeder
{

    use \SisFin\Repositories\GetClientesTrait;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clientes = $this->getClientes();

        factory(\SisFin\Models\BillPay::class, 400)
            ->make()
            ->each(function($billPay) use($clientes){
                $cliente = $clientes->random();
                $billPay->cliente_id = $cliente->id;
                $billPay->save();
            });
    }
}
