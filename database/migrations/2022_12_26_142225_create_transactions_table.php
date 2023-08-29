<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('subCategory_id')->nullable();
            $table->double("amount")->nullable();
            $table->unsignedBigInteger('payer')->nullable();
            $table->date('due_on');
            $table->integer('vat');
            $table->boolean('vat_inclusive');
            $table->enum('status',['Paid','Outstanding','Overdue'])->default('Paid');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('subCategory_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('payer')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('transactions');
    }
};
