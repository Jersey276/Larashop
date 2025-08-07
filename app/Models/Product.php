<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;
    public function categories():BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function defaultCategory()
    {
        return $this->categories()->wherePivot('default', true)->first();
    }
}
