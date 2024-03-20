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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->string('no_quote');
            $table->string('nama_penerima');
            $table->string('nama_customer');
            $table->string('alamat');
            $table->string('email');
            $table->string('no_hp');
            $table->string('nama_pic');
            $table->date('quote_date');
            $table->date('valid_date');
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
        Schema::dropIfExists('quotations');
    }
};
