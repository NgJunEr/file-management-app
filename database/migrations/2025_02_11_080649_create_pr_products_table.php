<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('pr_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pr_id')->constrained('prs')->onDelete('cascade');
            $table->string('product_name');
            $table->integer('quantity');
            $table->string('uom');
            $table->decimal('buying_price', 10, 3);
            $table->decimal('selling_price', 10, 3);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pr_products');
    }
};
