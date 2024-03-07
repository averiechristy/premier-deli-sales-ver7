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
        Schema::create('r_f_o_s', function (Blueprint $table) {
            $table->id();
            $table->string('nama_penerima');
            $table->string('nama_customer');
            $table->string('alamat');
            $table->unsignedBigInteger('cust_id');
            $table->date('shipping_date');
            $table->date('payment_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('r_f_o_s');
    }
};
