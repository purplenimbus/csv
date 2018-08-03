<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
		$user = new App\User(['name' => 'anthony','email' => 'anthony.akpan@hotmail.com','password' => Hash::make('easier')]);
		
		$user->save();
		
		var_dump($user);
    }
}
