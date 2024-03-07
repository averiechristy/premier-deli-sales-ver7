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
        Schema::create('detail_s_o_s', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('so_id');
            $table->unsignedBigInteger('product_id');
            $table->string('kode_produk');
            $table->string('nama_produk');
            $table->string('qty');
            $table->string('so_price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_s_o_s');
    }
};
