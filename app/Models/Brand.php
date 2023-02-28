<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Brand extends Model
{
    // id = reference
    use HasFactory;

    protected $fillable = ['name', 'reference'];

    public function Product(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function canBrandBeDeleted(string $id): bool
    {
        return DB::table('products')
            ->where('reference', '=', $id)
            ->exists();
    }
}
