<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use Faker\Factory as Faker;

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
            'name' => 'Jhone Doe',
            'email' => 'admin@example.com',
            'no_hp' => '934829308490238',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
        ]);
    }
}
