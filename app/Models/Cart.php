<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
    ];

    // 🔹 Relacionamento com o usuário
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 🔹 Itens do carrinho
    public function items()
    {
        return $this->hasMany(CartItem::class);
    }
}
