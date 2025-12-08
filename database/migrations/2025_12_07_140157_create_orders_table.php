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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->dateTime('order_date');
            $table->decimal('total', 15, 2);

            $table->decimal('pay', 15, 2)->nullable();
            $table->decimal('change', 15, 2)->nullable();

            $table->enum('status', [
                'pending',
                'confirmed',
                'shipped',
                'completed',
                'cancelled'
            ])->default('pending');

            $table->enum('payment_status', [
                'unpaid',
                'paid',
                'verified'
            ])->default('unpaid');

            $table->enum('payment_method', [
                'cod',
                'transfer'
            ])->default('transfer');

            $table->string('payment_proof_path')->nullable();
            $table->dateTime('payment_confirmed_at')->nullable();

            $table->foreignId('payment_confirmed_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('customer_name');
            $table->text('customer_address');
            $table->string('customer_phone');

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
