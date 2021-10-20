<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->nullable();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('thumbnail');
            $table->text('gallery');
            $table->string('unit');
            $table->integer('quantity');
            $table->bigInteger('price');
            $table->bigInteger('original_price')->nullable();
            $table->text('short_description')->nullable();
            $table->text('long_description')->nullable();;
            $table->text('details');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
