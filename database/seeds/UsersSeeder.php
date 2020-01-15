<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @author Panayiotis Halouvas <phalouvas@kainotomo.com>
     * 
     * @return void
     */
    public function run()
    {
        $email = env('ADMIN_EMAIL', 'admin@admin.com');
        $password = env('ADMIN_PASSWORD', 'Administr@tor');
        $admin = User::where('email', $email)->first();
        if (!$admin) {
            DB::table('users')->insert([
                'email'                => $email,
                'name'                 => 'Super Administrator',
                'password'             => bcrypt($password),
                'created_at'           => date('Y-m-d H:i:s'),
            ]);
            //assign to role
            $admin = User::where('email', $email)->first();
            $admin->assignRole('super-admin');
        }        
    }
}
