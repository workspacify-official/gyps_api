<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
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
            ['name' => 'md sawkat hossain', 'email' => 'saikat@workspacify.com', 'password' => '123456'],
            ['name' => 'masud', 'email' => 'masud@workspacify.com', 'password' => '123456']
        ];
        User::insert($user);
    }
}
