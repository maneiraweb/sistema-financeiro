<?php

use Illuminate\Database\Seeder;

class BancoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         factory(\SisFin\Models\Banco::class, 10)->create();
    }
}
