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
        Schema::table('r_f_o_s', function (Blueprint $table) {
            $table->enum('status_rfo', ['RFO terkirim', 'Menunggu pembuatan SO', 'Menunggu Pembayaran', 'Purchase Order', 'Pembuatan Invoice'])->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('r_f_o_s', function (Blueprint $table) {
            //
        });
    }
};
