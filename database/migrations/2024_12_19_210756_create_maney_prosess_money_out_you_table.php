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
        
        Schema::create('maney_prosess_money_out_you', function (Blueprint $table) {
            $table->id();
            $table->text('mone_proses')->nullable();
            $table->bigInteger('id_custmer')->nullable();
            $table->bigInteger('id_money')->nullable();
            $table->bigInteger('id_user')->nullable();
            $table->text('detels')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maney_prosess_money_out_you');
    }
};
