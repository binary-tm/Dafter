<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class supplier extends Model
{
    use HasFactory;
    protected $table = 'moared';
    protected $fillable = [
        'name',
        'date_',
        'address',
        'phone',
        'id_user',



 
    ];
}
