<?php

use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'username'=>'admin',
            'password'=>Crypt::encrypt('111111'),
            'salt'=>'',
            'status'=>1
        ]);
    }
}
