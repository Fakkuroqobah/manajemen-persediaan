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
        Schema::create('tb_barang_keluar', function (Blueprint $table) {
            $table->id('id_barang_keluar');
            $table->date('tanggal_barang_keluar');
            $table->unsignedBigInteger('id_customer');
            $table->unsignedBigInteger('id_kasir');
            $table->integer('jumlah_bayar')->nullable();
            $table->timestamps();
        });

        Schema::table('tb_barang_keluar', function (Blueprint $table) {
            $table->foreign('id_customer')->references('id_customer')->on('tb_customer')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();
            $table->foreign('id_kasir')->references('id_kasir')->on('tb_kasir')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_barang_keluar');
    }
};
