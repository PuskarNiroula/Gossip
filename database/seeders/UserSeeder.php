<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users=[
            [
                'name'=>"Puskar Niroula",
                "email"=>"puskar@gmail.com",
                "password"=>"password",
                'email_verified_at'=>now(),
            ],
            [
                'name'=>"Samana Dahal",
                "email"=>"samana@gmail.com",
                "password"=>"password",
                'email_verified_at'=>now(),
            ],
            [
                'name'=>"Ram Bahadur",
                "email"=>"ram@gmail.com",
                "password"=>"password",
                'email_verified_at'=>now(),
            ],
            [
                'name'=>"Sita Kumari",
                "email"=>"sita@gmail.com",
                "password"=>"password",
                'email_verified_at'=>now(),
            ],


        ];
        foreach ($users as $user){
            User::create($user);
        }

    }
}
