<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;

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

        // 🔹 Criar Pedidos + Itens + Pagamentos
        $clients = User::where('role', 'client')->get();
        foreach ($clients as $client) {
            // Cada cliente pode ter até 3 pedidos
            $orders = Order::factory()->count(rand(1, 3))->create([
                'user_id' => $client->id,
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
                    'payment_method' => fake()->randomElement(['credit_card', 'pix', 'boleto', 'paypal']),
                    'status' => fake()->randomElement(['pending', 'paid', 'failed']),
                    'amount' => $total,
                ]);
            }
        }
    }
}
