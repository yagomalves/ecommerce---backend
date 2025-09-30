<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Profile;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\ProductImage;
use App\Models\Review;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 🔹 Criar Super Admin fixo
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@site.com',
            'password' => bcrypt('123456'),
            'role' => 'super_admin',
            'email_verified_at' => now(),

        ]);

        // 🔹 Criar categorias fixas
        $categories = [
            'Eletrônicos',
            'Roupas',
            'Acessórios',
            'Casa e Jardim',
            'Livros',
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category,
                'slug' => strtolower(str_replace(' ', '-', $category)),
                'description' => "Categoria de $category",
            ]);
        }

        // 🔹 Criar Admins fake
        User::factory()->count(10)->create([
            'role' => 'admin',
        ]);

        // 🔹 Criar Clientes fake
        User::factory()->count(50)->create([
            'role' => 'client',
        ]);

        // 🔹 Criar Produtos fake
        Product::factory()->count(100)->create();

        //criar cart
        $clients = User::where('role', 'client')->get();
        foreach ($clients as $client) {
            Cart::factory()->create(['user_id' => $client->id]);
        }

        //criar cart items
        foreach (Cart::all() as $cart) {
            CartItem::factory()->count(rand(1, 5))->create([
                'cart_id' => $cart->id,
            ]);
        }

        // 🔹 Criar perfis para todos os usuários
        foreach (User::all() as $user) {
            Profile::factory()->create([
                'user_id' => $user->id,
            ]);
        }
        // 🔹 Criar Reviews fake
        Review::factory()->count(200)->create();

        // Adicionar Imagens a produtos
        foreach (Product::all() as $product) {
            // Uma imagem principal e 2 extras
            ProductImage::factory()->create([
                'product_id' => $product->id,
            ]);

            ProductImage::factory()->count(2)->create([
                'product_id' => $product->id,
            ]);
        }

        // 🔹 Criar Pedidos + Itens + Pagamentos
        $clients = User::where('role', 'client')->get();
        foreach ($clients as $client) {
            // Cada cliente pode ter até 3 pedidos
            $orders = Order::factory()->count(rand(1, 3))->create([
                'user_id' => $client->id,
                'shipping_address' => fake()->address(),
            ]);

            foreach ($orders as $order) {
                // Itens do pedido (2 a 5 produtos)
                $products = Product::inRandomOrder()->take(rand(2, 5))->get();
                $total = 0;

                foreach ($products as $product) {
                    $qty = rand(1, 3);
                    $price = $product->price;
                    $total += $qty * $price;

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $qty,
                        'price' => $price,
                    ]);
                }

                // Atualizar total do pedido
                $order->update(['total' => $total]);

                // Criar pagamento
                Payment::create([
                    'order_id' => $order->id,
                    'payment_status' => fake()->randomElement(['pending', 'approved', 'failed', 'refunded']),
                    'payment_method' => fake()->randomElement(['credit_card', 'pix', 'boleto', 'paypal']),
                    'transaction_id' => fake()->uuid(),
                ]);
            }

            
        }
    }
}
