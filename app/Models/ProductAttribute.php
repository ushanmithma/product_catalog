<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class ProductAttribute extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'name', 'attribute_value'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
