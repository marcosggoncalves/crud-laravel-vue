<?php

namespace App\Interfaces;

interface CategoryInterface
{
    public function index();

    public function store(array $request);

    public function update(int $id, array $request);

    public function destroy(int $id);
}
