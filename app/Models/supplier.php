<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class supplier extends Model
{
    use HasFactory;
    protected $table = 'supplier';
    protected $fillable = [
        'name',
        'date',
        'address',
        'phone',
        'id_user',



 
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'id_supplier'); // Assuming 'supplier_id' is the foreign key in transactions table
    }
}
