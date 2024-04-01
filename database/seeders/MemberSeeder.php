<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('members')->insert([
            'code' => '0311-0001',
            'firstname' => 'Post',
            'lastname' => 'Malone',
            'contact_number' => '09067247886',
            'email' => 'posty@gmail.com',
            'amount' => '1000.00',
            'payment_type' => 'gcash',
            'transaction_code' => 's657gra51r5a67',
            'subscription_start_date' => '2024-10-10',
            'subscription_end_date' => '2025-10-10',
            'subscription_status' => 'active',
        ]);
    }
}
