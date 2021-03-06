<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ClientesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(ContaBancariaTableSeeder::class);
        $this->call(CategoryExpensesTableSeeder::class);
        $this->call(CategoryRevenuesTableSeeder::class);
        $this->call(BillPayTableSeeder::class);
    }
}
