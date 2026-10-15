<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->string('item_code')->unique(); // e.g. SK-SUP-001
            $table->string('item_name');             // e.g. Molten Basketball GL7X
            $table->string('category');              // e.g. Sports Equipment
            $table->integer('quantity')->default(0);
            $table->string('unit');                  // e.g. pcs, reams, boxes
            $table->decimal('unit_price', 10, 2)->default(0.00);
            $table->string('status')->default('Available'); // Available, Low Stock, Out of Stock
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};