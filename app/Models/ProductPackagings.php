<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPackagings extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'packaging_name',
        'pieces_per_pack',
        'pack_price',
        'is_default'
    ];

    protected $casts = [
        'pack_price' => 'decimal:2',
        'pieces_per_pack' => 'integer',
        'is_default' => 'boolean'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
