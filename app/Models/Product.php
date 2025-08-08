<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    public $fillable = [
        'name',
        'description',
        'price',
        'reference',
        'stock',
        'sku',
        'category_id',
        //'image',
    ];
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function defaultCategory()
    {
        return $this->categories()->wherePivot('default', true)->first();
    }
}
