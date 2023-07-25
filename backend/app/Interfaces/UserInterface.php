<?php

namespace App\Interfaces;

interface UserInterface
{
    public function index();

    public function store(array $request);

    public function update(int $id, array $request);
    
    public function destroy(int $id);
}
