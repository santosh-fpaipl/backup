<?php
    namespace Tests\Feature;

    use Illuminate\Foundation\Testing\RefreshDatabase;
    use Illuminate\Foundation\Testing\WithFaker;
    use Tests\TestCase;
    use App\Models\Category;

    class CategoryTest extends TestCase
    {
        use RefreshDatabase;

        /** @test */
        public function can_create_a_category()
        {
            $response = $this->post('/categories', [
                'name' => 'New Category',
                'type' => 'material'
            ]);

            $response->assertStatus(201);
            $this->assertCount(1, Category::all());
        }

        /** @test */
        public function can_update_a_category()
        {
            $category = Category::factory()->create();

            $response = $this->put("/categories/{$category->id}", [
                'name' => 'Updated Category',
                'sid' =>'111'
            ]);

            $response->assertStatus(200);
            $this->assertEquals('Updated Category', $category->fresh()->name);
        }

        // ... Add more test cases for read, delete, edge cases, etc.
    }

?>