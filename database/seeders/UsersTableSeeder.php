<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Class UsersTableSeeder
 * 
 * @package Database\Seeders
 */
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            'user_id' => '0930952413',
            'email' => 'bhavik.test@yopmail.com',
            'password' => Hash::make('User12345'),
            'first_name' => 'Bhavik',
            'last_name' => 'Bhatiya',
        ];

        User::create($user);
    }
}
