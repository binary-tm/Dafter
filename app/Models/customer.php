<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\cus_reimbursement;
use App\Models\money_customer;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class customer extends Model
{
    use HasFactory;
    protected $table = 'castomer';
    protected $fillable = [
        'id',
        'name',
        'date_',
        'address',
        'phone',
        'id_user',



 
    ];

    public function user () {
        return $this->belongsTo(users::class,'id_user','id');
    }


    public function mony_cus () {
        return $this->belongsTo(money_customer::class,'id_custmer','id')->orderBy('id', 'desc');;
    }

    public function cus_remin () {
        return $this->belongsTo(cus_reimbursement::class,'id_custmer','id')->orderBy('id', 'desc');;
    }

 



   
}
