<?php

namespace Tests\Unit;

use App\Interfaces\UserInterface;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    public static function repository(): UserInterface
    {
        return new UserRepository();
    }

    private function gerarCadastro()
    {
        $cadastro = [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('1234'),
        ];

        return $cadastro;
    }

    public function testUsersList()
    {
        $newUser = $this->gerarCadastro();
        /// Save
        self::repository()->store($newUser);
        /// List
        $users = self::repository()->index();

        $this->assertTrue($users[0]->exists);
    }

    public function testUserStore()
    {
        $newUser = $this->gerarCadastro();
        /// Save
        $saveUser = self::repository()->store($newUser);

        $this->assertEquals($saveUser->name, $newUser['name']);
    }

    public function testUserEdit()
    {
        $newUser = $this->gerarCadastro();
        /// Save   
        $saveUser = self::repository()->store($newUser);
        /// Edit 
        $editaruser = self::repository()->update($saveUser->id, $newUser);

        $this->assertEquals($editaruser, true);
    }

    public function testUserDelete()
    {
        $newUser = $this->gerarCadastro();
        /// Save   
        $saveUser = self::repository()->store($newUser);
        /// Delete 
        $deleteUser = self::repository()->destroy($saveUser->id);

        $this->assertEquals($deleteUser, true);
    }
}
