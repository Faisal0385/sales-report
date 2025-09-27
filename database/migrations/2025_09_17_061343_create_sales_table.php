<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('sales_date');
            $table->string('day')->nullable();
            $table->string('month')->nullable();
            $table->string('year')->nullable();

            $table->decimal('cash_sales', 10, 2)->default(0);
            $table->decimal('techpoint_sales', 10, 2)->default(0);
            $table->decimal('tiktech_sales', 10, 2)->default(0);
            $table->decimal('card_sales', 10, 2)->default(0);

            $table->decimal('daily_total', 10, 2)->default(0);
            $table->string('company')->nullable();
            $table->string('branch')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
