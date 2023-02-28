<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'size', 'observation', 'quantity', 'brand_id', 'shipping'];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function getAllProducts()
    {
        return $this->join('brands', 'products.reference', '=', 'brands.reference')
            ->select('products.*', 'brands.name as brand_name')
            ->paginate(5);
    }
}
