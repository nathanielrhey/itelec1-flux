<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminManagementTest extends TestCase
{
    use RefreshDatabase;

    private function createCategory(): Category
    {
        return Category::create([
            'name' => 'Pet Food',
            'description' => 'Food for pets.',
        ]);
    }

    private function createProduct(Category $category, string $name = 'Dog Food'): Product
    {
        return Product::create([
            'category_id' => $category->id,
            'name' => $name,
            'description' => 'A sample product.',
            'price' => 12.50,
            'stock' => 8,
        ]);
    }

    public function test_admin_product_crud_and_validation(): void
    {
        $category = $this->createCategory();

        $this->get(route('admin.products.index'))
            ->assertOk()
            ->assertSee('Manage Catalog');

        $this->get(route('admin.products.create'))
            ->assertOk()
            ->assertSee('Create Product');

        $this->from(route('admin.products.create'))
            ->post(route('admin.products.store'), [
                'category_id' => $category->id,
                'name' => '',
                'price' => -1,
                'stock' => -2,
            ])
            ->assertRedirect(route('admin.products.create'))
            ->assertSessionHasErrors(['name', 'price', 'stock']);

        $this->assertDatabaseCount('products', 0);

        $this->post(route('admin.products.store'), [
            'category_id' => $category->id,
            'name' => 'Adult Cat Kibble',
            'description' => 'Balanced cat food.',
            'price' => '45.75',
            'stock' => 20,
        ])->assertRedirect(route('admin.products.index'));

        $product = Product::where('name', 'Adult Cat Kibble')->firstOrFail();
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'price' => 45.75,
            'stock' => 20,
        ]);

        $this->get(route('admin.products.edit', $product))
            ->assertOk()
            ->assertSee('Adult Cat Kibble');

        $this->put(route('admin.products.update', $product), [
            'category_id' => $category->id,
            'name' => 'Updated Cat Kibble',
            'description' => 'Updated description.',
            'price' => '55.00',
            'stock' => 15,
        ])->assertRedirect(route('admin.products.index'));

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Updated Cat Kibble',
            'price' => 55.00,
            'stock' => 15,
        ]);

        $index = $this->get(route('admin.products.index'));
        $index->assertOk()
            ->assertSee('onsubmit="return confirm(', false)
            ->assertSee('Delete', false);

        $this->delete(route('admin.products.destroy', $product))
            ->assertRedirect(route('admin.products.index'));
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    public function test_product_with_order_history_cannot_be_deleted(): void
    {
        $product = $this->createProduct($this->createCategory());
        $order = Order::create([
            'product_id' => $product->id,
            'customer_name' => 'Jamie Cruz',
            'quantity' => 1,
            'total_price' => 12.50,
            'status' => 'Pending',
        ]);

        $this->delete(route('admin.products.destroy', $product))
            ->assertRedirect(route('admin.products.index'))
            ->assertSessionHas('error');

        $this->assertDatabaseHas('products', ['id' => $product->id]);
        $this->assertDatabaseHas('orders', ['id' => $order->id]);
    }

    public function test_admin_can_update_order_status_with_validation(): void
    {
        $product = $this->createProduct($this->createCategory());
        $order = Order::create([
            'product_id' => $product->id,
            'customer_name' => 'Jamie Cruz',
            'quantity' => 1,
            'total_price' => 12.50,
            'status' => 'Pending',
        ]);

        $this->get(route('admin.orders.index'))
            ->assertOk()
            ->assertSee('Manage Order Status')
            ->assertSee('Pending');

        $this->patch(route('admin.orders.status', $order), ['status' => 'Ready'])
            ->assertRedirect(route('admin.orders.index'));
        $this->assertDatabaseHas('orders', ['id' => $order->id, 'status' => 'Ready']);

        $this->from(route('admin.orders.index'))
            ->patch(route('admin.orders.status', $order), ['status' => 'Cancelled'])
            ->assertRedirect(route('admin.orders.index'))
            ->assertSessionHasErrors('status');
        $this->assertDatabaseHas('orders', ['id' => $order->id, 'status' => 'Ready']);
    }

    public function test_catalog_api_returns_products_and_category_data(): void
    {
        $category = $this->createCategory();
        $product = $this->createProduct($category, 'Chicken Pet Treats');

        $this->getJson('/api/catalog')
            ->assertOk()
            ->assertJsonPath('data.0.id', $product->id)
            ->assertJsonPath('data.0.name', 'Chicken Pet Treats')
            ->assertJsonPath('data.0.price', '12.50')
            ->assertJsonPath('data.0.stock', 8)
            ->assertJsonPath('data.0.category.id', $category->id)
            ->assertJsonPath('data.0.category.name', 'Pet Food');
    }
}
