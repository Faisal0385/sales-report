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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();

            // Customer information
            $table->string('customer_name');
            $table->string('phone_number');
            $table->string('email')->nullable();
            $table->text('customer_address')->nullable();

            // Purchase information
            $table->date('purchase_date');
            $table->text('product_details');
            $table->string('imei_number')->unique(); // mandatory + unique
            $table->string('customer_id_proof')->nullable(); // image path

            // Payment information
            $table->enum('payment_method', ['cash', 'card', 'bank_transfer', 'other']);
            $table->decimal('purchase_amount', 10, 2); // stores amount in £

            // Category info
            $table->string('category');
            $table->string('sub_category');

            // Shop & Branch
            $table->string('day')->nullable();
            $table->string('month')->nullable();
            $table->string('year')->nullable();
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
        Schema::dropIfExists('purchases');
    }
};
