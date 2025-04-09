<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ProductImage extends Model
{
    use HasFactory;
    protected $table = 'product_images';

    protected $fillable = ['image', 'is_main', 'product_id'];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public $timestamps = false;
}
