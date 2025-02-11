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
        Schema::create('prs', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->foreignId('supplier_id')->constrained('suppliers');
            $table->foreignId('customer_id')->constrained('customers');
            $table->string('customer_po');
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prs');
    }
};
