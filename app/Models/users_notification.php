<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class users_notification extends Model
{
    use HasFactory;
    protected $table = 'users_notification';
    protected $fillable = [
        'user_id',
        'title',
        'content',
    ];

    public function name(){
        return $this->belongsTo(users::class); 
    }

}
