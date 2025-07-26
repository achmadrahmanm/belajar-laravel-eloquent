<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Database\Seeders\CategorySeeder;
use App\Models\Scopes\IsActiveScope;

class CategoryTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testInsertn(): void
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

    public function testInsertMany(): void
    {
        $categories = [];
        for ($i = 1; $i <= 10; $i++) {
            $categories[] = [
                'id' => 'cat-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'name' => 'Category ' . $i,
                'description' => 'This is the category number ' . $i . '.',
                'is_active' => true, // Assuming all categories are active by default
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


    public function testSelect(): void
    {
        for ($i = 1; $i <= 5; $i++) {
            $category = new Category();
            $category->id = 'cat-loop-' . $i;
            $category->name = 'Loop Category ' . $i;
            $category->description = 'Inserted in loop #' . $i;
            $category->save();
        }

        $categories = Category::where('id', 'like', 'cat-loop-%')->get();
        $this->assertCount(5, $categories, 'There should be 5 categories with id starting with cat-loop-*');

        // Update the description of the selected categories
        $categories->each(function ($category) {
            $category->description = 'Description updated';
            $category->save();
        });
    }

    public function testUpdate(): void
    {
        $this->seed(CategorySeeder::class);

        $category = Category::find('cat-001');
        $category->name = 'Updated Category 1';
        $category->save();

        $this->assertDatabaseHas('categories', [
            'id' => 'cat-001',
            'name' => 'Updated Category 1',
        ]);
    }


    public function testUpdateMany(): void
    {
        $categories = [];
        for ($i = 1; $i <= 8; $i++) {
            $categories[] = [
                'id' => 'cat-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'name' => 'Category ' . $i,
                'description' => 'This is the category number ' . $i . '.',
            ];
        }

        Category::insert($categories);
        $this->assertCount(8, $categories, 'There should be 8 categories with id starting with cat-loop-*');

        Category::where('id', 'like', 'cat-%')->update(
            ['description' => 'Description updated in bulk']
        );
    }

    public function testDelete(): void
    {
        $this->seed(CategorySeeder::class);

        $category = Category::find('cat-001');
        $category->delete();

        $this->assertDatabaseMissing('categories', [
            'id' => 'cat-001',
        ]);
    }

    public function testDeleteMany(): void
    {
        $categories = [];
        for ($i = 1; $i <= 5; $i++) {
            $categories[] = [
                'id' => 'cat-delete-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'name' => 'Category Delete ' . $i,
                'description' => 'This is the category number ' . $i . '.',
                'is_active' => true, // Assuming all categories are active by default
            ];
        }

        Category::insert($categories);
        $this->assertCount(5, Category::all(), 'There should be 5 categories before deletion.');

        Category::where('id', 'like', 'cat-delete-%')->delete();
        $this->assertCount(0, Category::where('id', 'like', 'cat-delete-%')->get(), 'All categories with id starting with cat-delete-* should be deleted.');
    }

    public function testUpdateMass(): void
    {
        $this->seed(CategorySeeder::class);

        $request = [
            'name' => 'Mass Updated Category',
            'description' => 'This category has been mass updated.',
        ];

        $category = Category::find('cat-001');
        $category->fill($request);
        $category->save();

        $this->assertDatabaseHas('categories', [
            'id' => 'cat-001',
            'name' => 'Mass Updated Category',
            'description' => 'This category has been mass updated.',
        ]);
    }

    public function testScopeActive(): void
    {
        // Now let's create an active category
        $category = new Category();
        $category->id = 'cat-active-001';
        $category->name = 'Active Category';
        $category->description = 'This category is active.';
        $category->is_active = true; // Set the active status
        $category->save();

        $activeCategories = Category::all();
        $this->assertCount(1, $activeCategories, 'There should be 1 active category after inserting an active category.');
    }

    public function testWithoutScope(): void
    {
        // Now let's create an inactive category
        $category = new Category();
        $category->id = 'cat-inactive-001';
        $category->name = 'Inactive Category';
        $category->description = 'This category is inactive.';
        $category->is_active = true; // Set the active status to false
        $category->save();

        $inactiveCategories  = Category::withoutGlobalScope(IsActiveScope::class)->find('cat-inactive-001');
        $this->assertNotNull($inactiveCategories, 'The inactive category should be found when global scope is removed.');
    }
}
