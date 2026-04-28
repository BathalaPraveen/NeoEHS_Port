<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $insertdata = [
            [
                "name" => "Admin User",
                "first_name" => "Admin",
                "last_name" => "User",
                "username" => 'admin',
                "email" => "admin@gmail.com",
                "department" => 1,
                'designation' => 1,
                "role" => 1,
                "mobile" => "3423423422",
                "profile_image" => "1641291529ib3bigQd7j.png",
                "remember_token" => "",
                "password" => Hash::make('asdF@1234567'),
                "created_by" => 1,
                "status" => 1,
                "trash" => "NO",
                "created_at" => null,
                "updated_at" => date('Y-m-d H:i:s')

            ],
        ];

        User::truncate();
        User::insert($insertdata);
    }
}
