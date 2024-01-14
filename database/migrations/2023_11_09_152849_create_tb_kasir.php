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
        Schema::create('tb_kasir', function (Blueprint $table) {
            $table->id('id_kasir');
            $table->string('nama_kasir', 30);
            $table->string('username', 20);
            $table->string('password', 255);
            $table->string('alamat_kasir', 30);
            $table->string('telepon_kasir', 13);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_kasir');
    }
};
