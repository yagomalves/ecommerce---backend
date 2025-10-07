<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;

class ProductImageFactory extends Factory
{
    // Lista das suas 10 imagens
    protected $localImages = [
        'produto00.jpeg',
        'produto01.webp', 
        'produto02.webp',
        'produto03.jpeg',
        'produto04.jpeg',
        'produto05.jpeg',
        'produto06.jpeg',
        'produto07.jpeg',
        'produto08.jpeg',
        'produto09.jpeg',
    ];

    public function definition(): array
    {
        // Escolhe uma imagem aleatória da lista
        $randomImage = $this->faker->randomElement($this->localImages);

        // ✅ Use a URL do servidor Laravel (127.0.0.1:8000)
        $imageUrl = 'http://127.0.0.1:8000/storage/product_images/' . $randomImage;
        
        return [
            'product_id' => 1, // Será sobrescrito pelo seeder
            'image_url' => $imageUrl,
        ];
    }
}