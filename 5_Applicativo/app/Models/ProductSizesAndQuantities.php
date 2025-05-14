<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ProductSizesAndQuantities extends Model
{
    use HasFactory;
    protected $table = 'sizes';

    protected $fillable = ['size', 'stock', 'product_id'];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public $timestamps = false;
}
