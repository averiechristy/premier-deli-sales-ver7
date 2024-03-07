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
        Schema::create('inovices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('so_id');
            $table->string('invoice_no');
            $table->unsignedBigInteger('cust_id');
            $table->date('invoice_date');
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inovices');
    }
};
