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
                $bankAccount = $cliente->bankAccounts->random();
                $category = $cliente->categoryExpenses->random();
                $billPay->cliente_id = $cliente->id;
                $billPay->bank_account_id = $bankAccount->id;
                $billPay->category_id = $category->id;
                $billPay->save();
            });
    }
}
