<?php

use Illuminate\Database\Seeder;

class FollowersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('followers')->insert([
            [
                'id' => '1',
                'mid' => "U4658895cbcdab9ae7e442550d350ed99",
                'name' => 'くんし',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],       
        ]);
    }
}
