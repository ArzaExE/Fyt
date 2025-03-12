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

    public $timestamps = false;
}
