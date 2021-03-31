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
        $users = [
            [
                'id'             => 1,
                'username'       => 'admin1',
                'email'          => 'admin1@st3telkom.ac.id',
                'password'       => '$2y$10$btX/Vd0NCwg1m9vo8LBRgulbMiI42h76VQX39O/Dh1lNV7p9sMTf2',
                'role'           => 'admin',
                'status'         => '1',
                'password_text'  => 'qwerty123',
                'remember_token' => null,
            ],
        ];
        User::insert($users);
    }
}
