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
        $repository = app(\SisFin\Repositories\ClienteRepository::class);
        $clientes = $repository->all();
        factory(\SisFin\Models\User::class, 1)
            ->states('admin')
            ->create([
                'name' => 'Gustavo Henrique Michels',
                'email' => 'admin@user.com',
            ]);
        
        foreach(range(1, 50) as $value) {
            factory(\SisFin\Models\User::class, 1)
                ->create([
                    'name' => "Cliente da Silva nº $value",
                    'email' => "client$value@user.com",
                ])->each(function($user) use($clientes){
                    $cliente = $clientes->random();
                    $user->cliente()->associate($cliente);
                    $user->save();
                });
        }
    }
}
