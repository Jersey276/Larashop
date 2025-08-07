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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('street');
            $table->string('city');
            $table->string('state')->nullable();
            $table->string('postal_code');
            $table->string('country');
            $table->unsignedInteger('reference')->nullable();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('invoice_address_id')->nullable()->constrained('addresses')->onDelete('set null');
            $table->foreignId('shipping_address_id')->nullable()->constrained('addresses')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['invoice_address_id']);
            $table->dropForeign(['shipping_address_id']);
            $table->dropColumn(['invoice_address_id', 'shipping_address_id']);
        });
        Schema::dropIfExists('addresses');
    }
};
