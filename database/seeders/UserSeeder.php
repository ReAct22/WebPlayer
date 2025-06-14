<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'User Gogomall',
                'email' => 'gogomall@email.com',
                'password' => 'gogomall'
            ],
            [
                'name' => 'Admin Gogomall',
                'email' => 'admin@email.com',
                'password' => 'admin'
            ]
        ];

        foreach ($users as $key ) {
            User::create($key);
        }
    }
}
