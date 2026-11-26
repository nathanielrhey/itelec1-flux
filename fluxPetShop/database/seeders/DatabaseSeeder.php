<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $food = Category::create([
            'name' => 'Pet Food',
            'description' => 'Dry kibble, wet pouches, and daily nutrition for dogs and cats.',
        ]);

        $grooming = Category::create([
            'name' => 'Grooming & Hygiene',
            'description' => 'Shampoos, brushes, ear cleaners, and nail care supplies.',
        ]);

        $accessories = Category::create([
            'name' => 'Accessories & Toys',
            'description' => 'Collars, leashes, bowls, and interactive play toys.',
        ]);

        $items = [
            [$food->id, 'Adult Dog Dry Kibble 5kg', 'Balanced chicken and rice kibble for adult dogs.', 890.00, 25],
            [$food->id, 'Kitten Wet Pouch Box (12s)', 'Tender salmon gravy pouches for kittens.', 540.00, 30],
            [$food->id, 'Hairball Control Cat Food 2kg', 'Fiber-rich dry formula to reduce hairballs.', 620.00, 18],
            [$food->id, 'Freeze-Dried Chicken Treats 150g', 'Single-ingredient high-protein training treats.', 280.00, 40],
            [$grooming->id, 'Oatmeal Soothing Pet Shampoo', 'Gentle soap-free shampoo for sensitive skin.', 250.00, 22],
            [$grooming->id, 'Slicker Grooming Brush', 'Fine stainless-steel pins for detangling coats.', 310.00, 15],
            [$grooming->id, 'Pet Ear Cleansing Solution', 'Mild vet-style ear cleaner for weekly care.', 220.00, 20],
            [$grooming->id, 'Pet Nail Clipper with Guard', 'Safety-guard trimmers for small to medium pets.', 195.00, 16],
            [$accessories->id, 'Reflective Nylon Dog Collar', 'Adjustable everyday collar with quick-release buckle.', 180.00, 35],
            [$accessories->id, 'Heavy-Duty Braided Leash', '1.5m reinforced leash for daily walks.', 290.00, 24],
            [$accessories->id, 'Stainless Steel Non-Slip Bowl', 'Rubber-base feeding bowl that resists tipping.', 240.00, 28],
            [$accessories->id, 'Interactive Cat Feather Wand', 'Engaging wand toy for daily indoor exercise.', 160.00, 32],
        ];

        $createdProducts = [];
        foreach ($items as [$categoryId, $name, $description, $price, $stock]) {
            $createdProducts[] = Product::create([
                'category_id' => $categoryId,
                'name' => $name,
                'description' => $description,
                'price' => $price,
                'stock' => $stock,
            ]);
        }

        Order::create([
            'product_id' => $createdProducts[0]->id,
            'customer_name' => 'Angela Santos',
            'quantity' => 2,
            'total_price' => 1780.00,
            'status' => 'Completed',
        ]);

        Order::create([
            'product_id' => $createdProducts[4]->id,
            'customer_name' => 'Marco Reyes',
            'quantity' => 1,
            'total_price' => 250.00,
            'status' => 'Pending',
        ]);
    }
}