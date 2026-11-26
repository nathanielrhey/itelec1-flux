<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use RuntimeException;
use Tests\TestCase;

class OrderFlowTest extends TestCase
{
    use RefreshDatabase;

    private function createSampleProduct(int $stock = 10, float $price = 250.00): Product
    {
        $category = Category::create([
            'name' => 'Pet Food',
            'description' => 'Daily nutrition for dogs and cats.',
        ]);

        return Product::create([
            'category_id' => $category->id,
            'name' => 'Adult Dog Dry Kibble 5kg',
            'description' => 'Balanced chicken and rice kibble.',
            'price' => $price,
            'stock' => $stock,
        ]);
    }

    public function test_front_page_and_catalog_page_render_separately_with_filtering(): void
    {
        $product = $this->createSampleProduct(12, 890.00);
        $grooming = Category::create([
            'name' => 'Grooming & Hygiene',
            'description' => 'Shampoos and brushes.',
        ]);
        $shampoo = Product::create([
            'category_id' => $grooming->id,
            'name' => 'Oatmeal Soothing Pet Shampoo',
            'description' => 'Gentle soap-free shampoo.',
            'price' => 250.00,
            'stock' => 20,
        ]);

        $homeResponse = $this->get(route('home'));
        $homeResponse->assertOk();
        $homeResponse->assertSee('images/flux-icon.png');
        $homeResponse->assertSee('images/flux-logo.png');
        $homeResponse->assertSee('Browse Catalog');
        $homeResponse->assertSee('Shop by Category');

        $catalogResponse = $this->get(route('catalog'));
        $catalogResponse->assertOk();
        $catalogResponse->assertSee('Product Catalog');
        $catalogResponse->assertSee($product->name);
        $catalogResponse->assertSee($shampoo->name);
        $catalogResponse->assertSee('12 in stock');

        $filteredResponse = $this->get(route('catalog', ['category' => $grooming->id]));
        $filteredResponse->assertOk();
        $filteredResponse->assertSee($shampoo->name);
        $filteredResponse->assertDontSee($product->name);

        $searchResponse = $this->get(route('catalog', ['search' => 'Kibble']));
        $searchResponse->assertOk();
        $searchResponse->assertSee($product->name);
        $searchResponse->assertDontSee($shampoo->name);
    }

    public function test_order_form_preselects_product_and_prefills_remembered_visitor_name(): void
    {
        $product = $this->createSampleProduct();

        $response = $this->withSession(['visitor_name' => 'Angela Santos'])
            ->get(route('orders.create', ['product_id' => $product->id]));

        $response->assertOk();
        $response->assertSee('value="Angela Santos"', false);
        $response->assertSee("value=\"{$product->id}\"", false);
    }

    public function test_order_validation_returns_errors_and_keeps_old_input_without_saving(): void
    {
        $this->createSampleProduct();

        $response = $this->from(route('orders.create'))
            ->post(route('orders.store'), [
                'customer_name' => 'A',
                'product_id' => '',
                'quantity' => 0,
            ]);

        $response->assertRedirect(route('orders.create'));
        $response->assertSessionHasErrors(['customer_name', 'product_id', 'quantity']);
        $response->assertSessionHasInput('customer_name', 'A');
        $response->assertSessionHasInput('quantity', 0);
        $this->assertDatabaseCount('orders', 0);
    }

    public function test_valid_order_commits_both_tables_and_sets_session_flash_and_memory(): void
    {
        $product = $this->createSampleProduct(stock: 10, price: 320.50);

        $response = $this->post(route('orders.store'), [
            'customer_name' => 'Marco Reyes',
            'product_id' => $product->id,
            'quantity' => 3,
        ]);

        $order = Order::firstOrFail();

        $response->assertRedirect(route('orders.show', $order));
        $response->assertSessionHas('success');
        $response->assertSessionHas('visitor_name', 'Marco Reyes');
        $response->assertSessionHas('last_order_id', $order->id);
        $response->assertSessionHas('last_order_reference', $order->reference_number);

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'product_id' => $product->id,
            'customer_name' => 'Marco Reyes',
            'quantity' => 3,
            'total_price' => 961.50,
            'status' => 'Pending',
        ]);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'stock' => 7,
        ]);
    }

    public function test_insufficient_stock_rolls_back_transaction_and_keeps_old_input(): void
    {
        $product = $this->createSampleProduct(stock: 2, price: 150.00);

        $response = $this->from(route('orders.create'))
            ->post(route('orders.store'), [
                'customer_name' => 'Clara Diaz',
                'product_id' => $product->id,
                'quantity' => 5,
            ]);

        $response->assertRedirect(route('orders.create'));
        $response->assertSessionHasErrors(['quantity']);
        $response->assertSessionHasInput('customer_name', 'Clara Diaz');
        $response->assertSessionHasInput('product_id', $product->id);
        $response->assertSessionHasInput('quantity', 5);

        $this->assertDatabaseCount('orders', 0);
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'stock' => 2,
        ]);
    }

    public function test_failure_during_stock_update_rolls_back_created_order(): void
    {
        $product = $this->createSampleProduct(stock: 10, price: 200.00);

        Product::updating(static function (): void {
            throw new RuntimeException('Simulated stock update failure');
        });

        try {
            $response = $this->post(route('orders.store'), [
                'customer_name' => 'Luis Tan',
                'product_id' => $product->id,
                'quantity' => 2,
            ]);
            $response->assertStatus(500);
        } finally {
            Product::flushEventListeners();
        }

        $this->assertDatabaseCount('orders', 0);
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'stock' => 10,
        ]);
    }

    public function test_status_page_displays_saved_order_with_related_product_and_category(): void
    {
        $product = $this->createSampleProduct(stock: 8, price: 450.00);

        $order = Order::create([
            'product_id' => $product->id,
            'customer_name' => 'Nina Cruz',
            'quantity' => 2,
            'total_price' => 900.00,
            'status' => 'Pending',
        ]);

        $response = $this->withSession([
            'visitor_name' => 'Nina Cruz',
            'last_order_id' => $order->id,
            'last_order_reference' => $order->reference_number,
        ])->get(route('orders.show', $order));

        $response->assertOk();
        $response->assertSee($order->reference_number);
        $response->assertSee('Nina Cruz');
        $response->assertSee($product->name);
        $response->assertSee('Pet Food');
        $response->assertSee('8 remaining');
    }

    public function test_status_shortcut_redirects_to_last_session_order_and_forget_clears_session(): void
    {
        $product = $this->createSampleProduct(stock: 5, price: 100.00);

        $order = Order::create([
            'product_id' => $product->id,
            'customer_name' => 'Sam Lee',
            'quantity' => 1,
            'total_price' => 100.00,
            'status' => 'Pending',
        ]);

        $this->withSession(['last_order_id' => $order->id])
            ->get(route('orders.status'))
            ->assertRedirect(route('orders.show', $order));

        $forgetResponse = $this->withSession([
            'visitor_name' => 'Sam Lee',
            'last_order_id' => $order->id,
            'last_order_reference' => $order->reference_number,
        ])->post(route('session.forget'));

        $forgetResponse->assertSessionMissing('visitor_name');
        $forgetResponse->assertSessionMissing('last_order_id');
        $forgetResponse->assertSessionMissing('last_order_reference');
    }

    public function test_seeded_data_and_orders_index_render_cleanly(): void
    {
        $this->seed();

        $this->assertDatabaseCount('categories', 3);
        $this->assertDatabaseCount('products', 12);
        $this->assertDatabaseCount('orders', 2);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Browse Catalog');

        $this->get(route('catalog'))
            ->assertOk()
            ->assertSee('Kitten Wet Pouch Box (12s)');

        $response = $this->get(route('orders.index'));

        $response->assertOk();
        $response->assertSee('Angela Santos');
        $response->assertSee('Marco Reyes');
        $response->assertSee('Adult Dog Dry Kibble 5kg');
        $response->assertSee('Oatmeal Soothing Pet Shampoo');
    }
}
