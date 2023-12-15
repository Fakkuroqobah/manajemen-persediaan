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
        Schema::create('tb_barang_masuk', function (Blueprint $table) {
            $table->id('id_barang_masuk');
            $table->date('tanggal_barang_masuk');
            $table->integer('jumlah_barang_masuk');
            $table->unsignedBigInteger('id_barang');
            $table->unsignedBigInteger('id_supplier');
            $table->timestamps();
        });

        Schema::table('tb_barang_masuk', function (Blueprint $table) {
            $table->foreign('id_barang')->references('id_barang')->on('tb_barang')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();
            $table->foreign('id_supplier')->references('id_supplier')->on('tb_supplier')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_barang_masuk');
    }
};
