<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
public function run()
    {
          $addresses = [
            '123 Main St, Dhaka', '456 Park Ave, Chittagong', '789 Lake Rd, Sylhet',
            '12 River St, Khulna', '34 Hill Rd, Rajshahi', '56 Beach St, Barishal'
        ];

        $phones = [
            '01710000001', '01820000002', '01930000003', '01640000004', '01550000005',
            '01760000006', '01870000007', '01980000008', '01690000009', '01500000010'
        ];

        $genders = ['male', 'female'];

        for ($i = 1; $i <= 20; $i++) {
            User::create([
                'name' => 'User ' . $i,
                'email' => 'user' . $i . '@example.com',
                'role' => 2, // user role
                'password' => Hash::make('12345'),
                'address' => $addresses[array_rand($addresses)],
                'phone' => $phones[array_rand($phones)],
                'gender' => $genders[array_rand($genders)],
                'remember_token' => Str::random(10),
            ]);
        }
    }
}
