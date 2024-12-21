<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class money_supplier extends Model
{
    use HasFactory;
    protected $table = 'money_out_you';
    protected $fillable = [
        'id_customer',
        'mone_cunt',
        'id_user',
        'details',
        'D',
        'M',
        'Y',


        
 
    ];
}
