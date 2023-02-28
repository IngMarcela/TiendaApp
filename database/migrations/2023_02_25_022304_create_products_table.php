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
        Schema::create('products', function (Blueprint $table) {
            $table->id()->comment('product id');
            $table->string('name', 50)->nullable(false)->comment('product name assigned by the company');
            $table->enum('size', ['S', 'M', 'L'])->nullable(false)->comment('sizes allowed by the company');
            $table->text('observation')->nullable(false)->comment('observations made on the companys products');
            $table->unsignedSmallInteger('quantity')->nullable(false)->comment('amount of inventory we have of a product');
            $table->unsignedBigInteger('reference')->nullable(false)->comment('brand reference');
            $table->date('shipping')->nullable(false)->comment('date of product shipment');
            $table->timestamps();

            $table->foreign('reference')
                ->references('reference')
                ->on('brands')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
