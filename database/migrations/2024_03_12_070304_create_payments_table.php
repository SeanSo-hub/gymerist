<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('member_id');
            $table->string('amount');
            $table->date('date');
            $table->enum('mode', ['cash', 'gcash']);
            $table->string('transaction_code')->nullable();
            $table->enum('type', ['annual', 'bi-monthly', 'monthly']);
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
            $table->enum('status', ['active', 'expired']);
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
        Schema::dropIfExists('payments');
    }
}
