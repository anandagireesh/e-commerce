<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->decimal('total_price', 10, 2);
            $table->decimal('shipping_cost', 10, 2)->nullable();
            $table->decimal('discount', 10, 2)->nullable();
            $table->decimal('grand_total', 10, 2);
            $table->enum('payment_method', ['cash', 'bank_transfer', 'card'])->nullable();
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->nullable();
            $table->enum('order_status', ['pending', 'processing', 'shipped', 'delivered', 'cancelled'])->nullable();
            $table->dateTime('order_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->foreignId('order_address')->constrained('addresses');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
