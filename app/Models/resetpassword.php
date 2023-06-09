<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class resetpassword extends Model
{
   
    use HasFactory;
    protected $table = 'resetpassword';
    protected $fillable = [
        'code_',
        'id_user',
        


 
    ];
}

