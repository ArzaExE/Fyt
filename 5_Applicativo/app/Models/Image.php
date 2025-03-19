<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Image extends Model
{
    protected $table = 'product_images';
    use HasFactory;

    protected $fillable = [
        'product_id',
        'image'
    ];
    public $timestamps = false;


}
