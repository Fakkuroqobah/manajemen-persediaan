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
        Schema::create('tb_barang_retur', function (Blueprint $table) {
            $table->id('id_barang_retur');
            $table->date('tanggal_barang_retur');
            $table->text('deskripsi');
            $table->int('jumlah');
            $table->unsignedBigInteger('id_penjualan_detail');
            $table->timestamps();
        });

        Schema::table('tb_barang_retur', function (Blueprint $table) {
            $table->foreign('id_penjualan_detail')->references('id_penjualan_detail')->on('tb_penjualan_detail')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_barang_retur');
    }
};
