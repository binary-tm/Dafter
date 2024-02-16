<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class money_customer extends Model
{
    use HasFactory;
    protected $table = 'money_for_you';
    protected $fillable = [
        'id_custmer',
        'mone_cunt',
        'id_user',
        'detels',
        'D',
        'M',
        'Y',
     

        
 
    ];

    public function cus () {
        return $this->belongsTo(customer::class,'id_custmer','id');
    }
}
