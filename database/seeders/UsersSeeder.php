<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name'  => 'Confirmed User Demo',
                'email' => 'confirmed@user.test',
                'password' => Hash::make('password'),
                'email_verified_at' => now()
            ],
            [
                'name'  => 'Unconfirmed User Demo',
                'email' => 'unconfirmed@user.test',
                'password' => Hash::make('password'),
                'email_verified_at' => null
            ]
        ];

        foreach ($users as $user) {
            User::query()->updateOrCreate(['email' => $user['email']], $user);
        }
    }
}
