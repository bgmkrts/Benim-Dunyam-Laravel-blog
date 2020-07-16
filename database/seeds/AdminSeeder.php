<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'name'=>'Benim Dünyam Admin',
            'email'=>'benimdunyam@blog.com',
            'password'=>bcrypt(180618),
        ]);

    }
}
