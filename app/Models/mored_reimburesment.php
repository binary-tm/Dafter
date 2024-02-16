<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mored_reimburesment extends Model
{
    use HasFactory;
    protected $table = 'maney_prosess_money_out_you';
    protected $fillable = [
        'id_custmer',
        'mone_proses',
        'id_user',
        'detels',
        'D',
        'M',
        'Y',


        
 
    ];
}
