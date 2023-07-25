<?php

namespace Tests\Unit;

use App\Interfaces\ProductInterface;
use App\Models\Category;
use App\Repositories\ProductRepository;
use Tests\TestCase;

class ProductTest extends TestCase
{
    public static function repository(): ProductInterface
    {
        return new ProductRepository();
    }

    private function gerarCadastro()
    {
        $newCategory = Category::create(['name' => fake()->name()]);

        return ['name' => fake()->word(), 'category_id' => $newCategory->id];
    }

    public function testProductsList()
    {
        $newCategory = $this->gerarCadastro();
        /// Save
        self::repository()->store($newCategory);
        /// List 
        $categories = self::repository()->index();

        $this->assertNotEmpty($categories);
    }

    public function testProductStore()
    {
        $newCategory = $this->gerarCadastro();
        /// Save
        $saveCategory = self::repository()->store($newCategory);

        $this->assertEquals($saveCategory->name, $newCategory['name']);
    }

    public function testProductEdit()
    {
        $newCategory = $this->gerarCadastro();
        /// Save  
        $saveCategory = self::repository()->store($newCategory);
        /// Edit
        $editCategory = self::repository()->update($saveCategory->id, $newCategory);

        $this->assertEquals($editCategory, true);
    }

    public function testProductDelete()
    {
        $newCategory = $this->gerarCadastro();
        /// Save  
        $saveCategory = self::repository()->store($newCategory);
        /// Delete
        $deleteCategory = self::repository()->destroy($saveCategory->id);

        $this->assertEquals($deleteCategory, true);
    }
}
