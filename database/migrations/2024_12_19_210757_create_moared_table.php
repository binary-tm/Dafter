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
        Schema::create('moared', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->text('date_')->nullable();
            $table->text('address')->nullable();
            $table->text('phone')->nullable();
            $table->bigInteger('id_user')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('moared');
    }
};
