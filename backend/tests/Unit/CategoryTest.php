<?php

namespace Tests\Unit;

use App\Interfaces\CategoryInterface;
use App\Repositories\CategoryRepository;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    public static function repository(): CategoryInterface
    {
        return new CategoryRepository();
    }

    private function gerarCadastro()
    {
        return ['name' => "Categoria " . fake()->name()];
    }

    public function testCategoriesList()
    {
        $newCategory = $this->gerarCadastro();
        /// Save
        self::repository()->store($newCategory);
        /// List 
        $categories = self::repository()->index();

        $this->assertNotEmpty($categories);
    }

    public function testCategoryStore()
    {
        $newCategory = $this->gerarCadastro();
        /// Save
        $saveCategory = self::repository()->store($newCategory);

        $this->assertEquals($saveCategory->name, $newCategory['name']);
    }

    public function testCategoryEdit()
    {
        $newCategory = $this->gerarCadastro();
        /// Save  
        $saveCategory = self::repository()->store($newCategory);
        /// Edit
        $editCategory = self::repository()->update($saveCategory->id, $newCategory);

        $this->assertEquals($editCategory, true);
    }

    public function testCategoryDelete()
    {
        $newCategory = $this->gerarCadastro();
        /// Save  
        $saveCategory = self::repository()->store($newCategory);
        /// Delete
        $deleteCategory = self::repository()->destroy($saveCategory->id);

        $this->assertEquals($deleteCategory, true);
    }
}
