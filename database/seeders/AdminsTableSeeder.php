<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = [
            [
                'id'            => 1,
                'user_id'       => '1',
                'admin_nama'    => 'Nama Admin 1',
                'admin_image'   => 'user.png',
                
            ],
        ];
        Admin::insert($admin); 
    }
}
