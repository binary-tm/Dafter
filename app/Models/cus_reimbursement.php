<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cus_reimbursement extends Model
{
    use HasFactory;
    protected $table = 'maney_prosess_money_for_you';
    protected $fillable = [
        'id_customer',
        'mone_proses',
        'id_user',
        'details',

        
 
    ];


    public function cus () {
        return $this->belongsTo(customer::class,'id_custmer','id');
    }


}
