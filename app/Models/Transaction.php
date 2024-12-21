<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_user',
        'id_supplier',
        'id_customer',
        'amount',
        'type',
        'transactions_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'id_supplier'); // Assuming 'supplier_id' is the foreign key
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer'); // Assuming 'customer_id' is the foreign key
    }
}
