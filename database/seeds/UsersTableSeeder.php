<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\SisFin\User::class, 1)
            ->states('admin')
            ->create([
                'name' => 'Gustavo Henrique Michels',
                'email' => 'admin@user.com'
            ]);
        
        factory(\SisFin\User::class, 1)
            ->create([
                'name' => 'João da Silva',
                'email' => 'client@user.com'
            ]);
    }
}
