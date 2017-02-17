<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use SisFin\Models\User;

class UserTest extends TestCase
{

    use DatabaseTransactions;
    public function testCreateUser() {
        User::create([
            'name' => 'TesteUser',
            'email' => 'teste@user.com.br',
            'password' => bcrypt(123456)
        ]);

        $this->seeInDatabase('users',
            [
            'name' => 'TesteUser',
            ]
        );
    }

}
