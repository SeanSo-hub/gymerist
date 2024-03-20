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
            $table->string('code');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('contact_number', 15);
            $table->string('email');
            $table->date('subscription_date')->nullable();  
            $table->date('subscription_end_date')->nullable(); 
            $table->enum('subscription_status', ['active', 'expired'])->default('expired');     
            $table->enum('status', ['active', 'expired'])->default('expired')->nullable(); ;
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
