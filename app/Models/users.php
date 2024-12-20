<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class users extends Model
{
    use HasApiTokens, Notifiable;
    
    
    protected $table = 'users';
    protected $fillable = [
        'name',
        'email',
        'password',
        'notification_id'


 
    ];
    

    public function cust () {
        return $this->hasMany(customer::class,'id_user','id')->orderBy('id', 'desc');
    }
}
