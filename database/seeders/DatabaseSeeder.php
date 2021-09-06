<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory()->staff()->create([
            'name'  => 'Staff',
            'email' => 'staff@example.com'
        ]);

        \App\Models\Customer::factory()
            ->has(User::factory()
                ->state(function (array $attributes, Customer $customer) {
                    return [
                        'name'  => 'Customer User',
                        'email' => 'customer@example.com'
                    ];
                }), 'users')
            ->create(['name' => 'Customer A']);
    }
}
