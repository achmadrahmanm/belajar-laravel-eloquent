<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CatergoryTest extends TestCase
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
}
