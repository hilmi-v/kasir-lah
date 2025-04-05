<?php

namespace Database\Seeders;

use Carbon\Carbon;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Sale;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\SaleDetail;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'admin@gmail.com',
        ]);

        // Seed Categories
        $categories = ['Seragam', 'Aksesoris', 'Sepatu', 'Sandal', 'lainnya'];
        foreach ($categories as $category) {
            Category::create([
                'name' => $category
            ]);
        }

        // Seed Products
        $products = [
            ['name' => 'Baju SD pendek no 5', 'stock' => 10, 'price' => 70000, 'category_id' => 1],
            ['name' => 'Celana SD panjang no 5', 'stock' => 10, 'price' => 80000, 'category_id' => 1],
            ['name' => 'Celana SMP panjang no 5', 'stock' => 10, 'price' => 100000, 'category_id' => 1],
            ['name' => 'Ikat Pinggang SD', 'stock' => 20, 'price' => 10000, 'category_id' => 2],
            ['name' => 'Kaos Kaki SD', 'stock' => 20, 'price' => 5000, 'category_id' => 2],
            ['name' => 'Sepatu NB', 'stock' => 50, 'price' => 50000, 'category_id' => 3],
            ['name' => 'Sepatu bola', 'stock' => 50, 'price' => 100000, 'category_id' => 3],
            ['name' => 'swallow', 'stock' => 50, 'price' => 15000, 'category_id' => 4],
            ['name' => 'carvil', 'stock' => 50, 'price' => 75000, 'category_id' => 4],
            ['name' => 'payung', 'stock' => 50, 'price' => 25000, 'category_id' => 5],
            ['name' => 'topi', 'stock' => 50, 'price' => 25000, 'category_id' => 5],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }

        // Seed Sales & Sale Details (30 Hari Terakhir)
        for ($i = 0; $i < 500; $i++) {
            $randomDate = Carbon::now()->subDays(rand(0, 30));
            $sale = Sale::create([
                'original_total' => 0,
                'grand_total' => 0,
                'payment' => 0,
                'change' => 0,
                'created_at' => $randomDate,
                'updated_at' => $randomDate
            ]);

            $total = 0;
            $productSamples = Product::inRandomOrder()->limit(rand(1, 3))->get();

            foreach ($productSamples as $product) {
                $quantity = rand(1, 5);
                $subTotal = $product->price * $quantity;
                $total += $subTotal;

                SaleDetail::create([
                    'sale_id' => $sale->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'subTotal' => $subTotal,
                    'created_at' => $randomDate,
                    'updated_at' => $randomDate
                ]);
            }

            // Update total di tabel sales
            $sale->update([
                'original_total' => $total,
                'grand_total' => $total,
                'payment' => $total + 5000, // Misalnya ada uang lebih
                'change' => 5000
            ]);
        }
    }
}
