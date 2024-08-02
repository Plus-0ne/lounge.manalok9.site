<?php

namespace Database\Seeders;

use Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'admin_id' => '08bea9cc-abbb-4125-ae6a-339318b1b38b',
            'user_uuid' => 'badea2d3-0575-4ab2-b41a-fed8a5d5c086',
            'email_address' => 'devt5599@gmail.com',
            'password' => Hash::make('123456password'),
            'department' => 'IT',
            'position' => 'Web Developer',
            'roles' => '1',
            'added_by' => 'badea2d3-0575-4ab2-b41a-fed8a5d5c076',
            'remember_token' => NULL,
            'deleted_at' => NULL,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];
        DB::table('admins')->insert($data);
    }
}
