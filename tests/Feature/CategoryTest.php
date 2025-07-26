<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Database\Seeders\CategorySeeder;

class CategoryTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testCategoryCreation(): void
    {
        $category = new Category();

        $category->id = 'cat-001';
        $category->name = 'Category 1';
        $category->description = 'This is the first category.';
        $category->save();

        $this->assertDatabaseHas('categories', [
            'id' => 'cat-001',
            'name' => 'Category 1',
            'description' => 'This is the first category.',
        ]);
    }

    public function testInsertManyCategories(): void
    {
        $categories = [];
        for ($i = 1; $i <= 10; $i++) {
            $categories[] = [
                'id' => 'cat-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'name' => 'Category ' . $i,
                'description' => 'This is the category number ' . $i . '.',
            ];
        }

        // Category::query()->insert($categories); 
        // Using Category::query()->insert($categories) is same as Category::insert($categories) 
        Category::insert($categories);
        $total = Category::count();
        $this->assertEquals(10, $total, 'Total categories should be 10 after inserting 9 more categories.');
    }

    public function testFind(): void
    {
        $this->seed(CategorySeeder::class);

        $category = Category::find('cat-001');
        $this->assertNotNull($category, 'Category with id cat-001 should exist.');
        $this->assertEquals('Category 1', $category->name, 'Category name should be Category 1.');
    }
}
