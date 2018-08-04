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
		
		$users = [
			[
				'name' => 'anthony',
				'email' => 'anthony.akpan@hotmail.com',
				'password' => Hash::make('easier')
			],[
				'name' => 'melinda',
				'email' => 'melinda.epifano@hotmail.com',
				'password' => Hash::make('bella')
			]
		];
		
		$count = 0;
		
		foreach($users as $user){
			$new_user = new App\User($user);
		
			$new_user->save();
			
			 \Log::info('Created an account for '.$new_user->name);
			 
			var_dump($user);
			$count++;
		}
		
		\Log::info('Created '.$count.' test users');
    }
}
