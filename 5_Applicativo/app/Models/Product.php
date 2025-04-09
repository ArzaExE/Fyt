<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Product extends Model
{
    use HasFactory;

    public function getFormattedReleaseDateAttribute()
    {
        return Carbon::parse($this->release_date)->format('d-m-Y');
    }

    protected $fillable = [
        'name',
        'description',
        'color',
        'release_date',
        'price'
    ];

    // Relazione uno-a-molti con le immagini
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    // Relazione per l'immagine principale (opzionale)
    public function mainImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_main', true);
    }

    public $timestamps = false;

    public function getFormattedReleaseDateForFormAttribute()
    {
        return Carbon::parse($this->release_date)->format('Y-m-d');
    }
}
