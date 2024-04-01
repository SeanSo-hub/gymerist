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
            $table->decimal('amount', 10, 2)->nullable();
            $table->enum('plan_type', ['session', 'monthly', 'quarterly', 'half-year', 'annual'])->default('session');
            $table->date('plan_start_date')->nullable();
            $table->date('plan_end_date')->nullable();          
            $table->enum('payment_type', ['cash', 'gcash'])->nullable();
            $table->string('transaction_code')->nullable();
            $table->enum('plan_status', ['active', 'expired'])->default('expired');
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
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
