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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->string('firstname')->default('');
            $table->string('lastname')->default('');
            $table->string('contact_number', 15)->default('');
            $table->string('email')->default('');
            $table->decimal('amount', 10, 2)->nullable();
            $table->enum('payment_type', ['cash', 'gcash'])->nullable();
            $table->string('transaction_code')->nullable();
            $table->date('subscription_start_date')->nullable();  
            $table->date('subscription_end_date')->nullable(); 
            $table->enum('subscription_status', ['active', 'expired'])->default('expired');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
