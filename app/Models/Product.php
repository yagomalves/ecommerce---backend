<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'user_id',
        'name',
        'slug',
        'description',
        'price',
        'stock_quantity',
        'status',
    ];

    // 🔹 Relacionamentos
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // App/Models/Product.php

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            $baseSlug = Str::slug($product->name);
            $uniqueSlug = $baseSlug;
            $count = 1;

            while (Product::where('slug', $uniqueSlug)->exists()) {
                $uniqueSlug = "{$baseSlug}-{$count}";
                $count++;
            }

            $product->slug = $uniqueSlug;
        });

        static::updating(function ($product) {
            if ($product->isDirty('name')) {
                $baseSlug = Str::slug($product->name);
                $uniqueSlug = $baseSlug;
                $count = 1;

                while (Product::where('slug', $uniqueSlug)
                    ->where('id', '!=', $product->id)
                    ->exists()
                ) {
                    $uniqueSlug = "{$baseSlug}-{$count}";
                    $count++;
                }

                $product->slug = $uniqueSlug;
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
}
