<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Bang',
            'user_name' => 'admin',
            'email' => 'dinhbang19@gmail.com',
            'password' => bcrypt('admin123'),
        ]);
    }
}
