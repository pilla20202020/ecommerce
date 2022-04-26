<?php

namespace App\Models\Deal;

use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    protected $fillable=['product_id','offer_price','is_featured'];

    protected $casts = [
        'is_featured' => 'boolean',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

