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
        Schema::create('detail_r_f_o_s', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rfo_id');
            $table->unsignedBigInteger('product_id');
            $table->string('kode_produk');
            $table->string('nama_produk');
            $table->integer('qty');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_r_f_o_s');
    }
};
