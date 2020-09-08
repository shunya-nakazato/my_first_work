<?php

use Illuminate\Database\Seeder;

class AppUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $today = date("Y-m-d H:i:s");

        DB::table('app_users')->insert([
            [
                'id' => 1,
                'name' => 'test1',
                'email' => 'test1@test.com',
                'created_at' => $today,
                'updated_at' => $today,
                'password' => 'password',
            ],
            [
                'id' => 2,
                'name' => 'test2',
                'email' => 'test2@test.com',
                'created_at' => $today,
                'updated_at' => $today,
                'password' => 'password',
            ],
            [
                'id' => 3,
                'name' => 'test3',
                'email' => 'test3@test.com',
                'created_at' => $today,
                'updated_at' => $today,
                'password' => 'password',
            ],
            [
                'id' => 4,
                'name' => 'test4',
                'email' => 'test4@test.com',
                'created_at' => $today,
                'updated_at' => $today,
                'password' => 'password',
            ],
            [
                'id' => 5,
                'name' => 'test5',
                'email' => 'test5@test.com',
                'created_at' => $today,
                'updated_at' => $today,
                'password' => 'password',
            ],
            [
                'id' => 6,
                'name' => 'test6',
                'email' => 'test6@test.com',
                'created_at' => $today,
                'updated_at' => $today,
                'password' => 'password',
            ],
            [
                'id' => 7,
                'name' => 'test7',
                'email' => 'test7@test.com',
                'created_at' => $today,
                'updated_at' => $today,
                'password' => 'password',
            ],
            [
                'id' => 8,
                'name' => 'test8',
                'email' => 'test8@test.com',
                'created_at' => $today,
                'updated_at' => $today,
                'password' => 'password',
            ],
            [
                'id' => 9,
                'name' => 'test9',
                'email' => 'test9@test.com',
                'created_at' => $today,
                'updated_at' => $today,
                'password' => 'password',
            ]
        ]);
    }
}
