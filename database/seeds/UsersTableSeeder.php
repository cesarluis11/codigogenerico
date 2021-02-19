<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //usuarios con el rol super-admin
        $admin = User::create([
        	'name' => 'ADMINISTRADOR',
        	'email' => 'adm@gmail.com',
        	'password' => bcrypt('administrador')
        ]);
        $admin->assignRole('super-admin');

        $diseno = User::create([
        	'name' => 'DISEÑADOR',
        	'email' => 'diseno@gmail.com',
        	'password' => bcrypt('diseñador')
        ]);
        $diseno->assignRole('diseno');
    }
}
