<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 1000)->create()->each(function ($user) {
            $user->role = 'patient';
            $user->save();
        });

        // practice staff - admin 20
         factory(App\User::class, 25)->create()->each(function ($user) {
            $user->role = 'admin';
            $user->save();
        });

         // practice staff - admin 15
         factory(App\User::class, 25)->create()->each(function ($user) {
            $user->role = 'nurse';
            $user->save();
        });

         // practice staff - admin 15
         factory(App\User::class, 25)->create()->each(function ($user) {
            $user->role = 'doctor';
            $user->save();
        });
    }
}
