<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
                    'first_name'          =>  'Employee',
                    'last_name'           =>  'One',
                    'email'               =>  'employee_one@gmail.com',
                    'employee_id'         =>  rand(1000000000, 9999999999),
                    'password'            =>  Hash::make('123456'),
                ];

        User::firstOrCreate(['email' => $user['email']], $user);
    }
}
