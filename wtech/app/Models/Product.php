<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\ProductSizes;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'slug',
        'description',
        'manufacturer',
        'gender',
        'color',
        'type',
        'price',
        'isSale',
        'salePrice',
        'release_date',
    ];

    public function sizes()
    {
        return $this->hasMany(ProductSizes::class);
    }
}
