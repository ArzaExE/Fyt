<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class user_roles extends Model
{
    use HasFactory;

    protected $table = 'user_roles';

    protected $fillable = [
        'id',
        'name'
    ];
    public $timestamps = false;
}
