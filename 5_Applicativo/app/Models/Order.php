<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // Relazione con User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
