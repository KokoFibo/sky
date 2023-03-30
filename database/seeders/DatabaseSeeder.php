<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\Customer::factory(20)->create();
        // \App\Models\Package::factory(5)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        DB::table('packages')->insert(
            [
                'package' => 'Standard Package 15-20',
                'price' => '4500000',
            ]
        );
        DB::table('packages')->insert(
            [
                'package' => 'Corporate Package 30-40',
                'price' => '9000000',
            ]
        );
        DB::table('packages')->insert(
            [
                'package' => 'UMKM 12 with Photography',
                'price' => '3500000',
            ]
        );
        DB::table('contracts')->insert(
            [
                'customer_id' => '1',
                'contract_number' => 'Contract-001',
                'contract_begin' => '2023-03-01',
                'contract_end' => '2023-06-01',
            ]
        );
        DB::table('contracts')->insert(
            [
                'customer_id' => '1',
                'contract_number' => 'Contract-005',
                'contract_begin' => '2023-03-01',
                'contract_end' => '2023-06-01',
            ]
        );
        DB::table('contracts')->insert(
            [
                'customer_id' => '2',
                'contract_number' => 'Contract-002',
                'contract_begin' => '2023-03-01',
                'contract_end' => '2023-07-01',
            ]
        );
        DB::table('contracts')->insert(
            [
                'customer_id' => '3',
                'contract_number' => 'Contract-003',
                'contract_begin' => '2023-03-01',
                'contract_end' => '2023-08-01',
            ]
        );



    }
}
