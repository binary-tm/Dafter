<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class users extends Model
{
    use HasFactory;
    protected $table = 'users';
    protected $fillable = [
        'name',
        'email',
        'password_',



 
    ];

    public function cust () {
        return $this->hasMany(customer::class,'id_user','id')->orderBy('id', 'desc');
    }
}
