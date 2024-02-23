<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\ProductStatus;
use App\Models\ProductAttribute;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'category', 'name', 'description', 'selling_price', 'special_price', 'status', 'is_delivery_available', 'image'];

    protected $casts = [
        'status' => ProductStatus::class
    ];

    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class, 'product_id');
    }
}
