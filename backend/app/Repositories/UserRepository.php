<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Interfaces\UserInterface;

class UserRepository implements UserInterface
{
    public function hashPassword($password)
    {
        return Hash::make($password);
    }

    public function index()
    {
        return User::orderBy('name')->paginate(15);
    }

    public function store(array $body)
    {
        return User::create([
            'name' => $body['name'],
            'email' => $body['email'],
            'password' => $this->HashPassword($body['password'])
        ]);
    }

    public function update(int $id, array $body)
    {
        $user = User::findOrFail($id);
        $user->name = $body['name'];
        $user->email = $body['email'];

        if (isset($body['password'])) {
            $user->password = $this->HashPassword($body['password']);
        }

        return $user->save();
    }

    public function destroy(int $id)
    {
        return User::destroy($id);
    }
}
