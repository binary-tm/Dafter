<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->unsignedBigInteger('id_user'); // Foreign key to users table
            $table->unsignedBigInteger('id_supplier')->nullable(); // Foreign key to suppliers table, optional
            $table->unsignedBigInteger('id_customer')->nullable(); // Foreign key to customers table, optional
            $table->bigInteger('amount',  ); // Transaction amount
            $table->string('type'); // e.g., 'credit' or 'debit'
            $table->bigInteger('transactions_id'); // e.g., 'credit' or 'debit'
            $table->timestamps(); // timestamps for created_at and updated_at
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_supplier')->references('id')->on('moared')->onDelete('cascade');
            $table->foreign('id_customer')->references('id')->on('castomer')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
