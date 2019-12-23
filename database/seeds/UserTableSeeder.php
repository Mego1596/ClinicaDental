<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Persona;
use Caffeinated\Shinobi\Models\Role;
class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Users
    	$user = User::create([
    		'name'              => 'Kimberly',
    		'email'             => 'maurigranados1596@gmail.com',
    		'password'          => bcrypt('admin'),
    	]);

        Persona::create([
            'primer_nombre'     => 'Kimberly',
            'segundo_nombre'    => 'Johanna',
            'primer_apellido'   => 'Amaya',
            'segundo_apellido'  => 'Jimenez',
            'direccion'         => 'Direccion de casa',
            'user_id'           => $user->id
        ]);

    	Role::create([
    		'name' 		     => 'Administrador',
    		'slug' 		     => 'admin',
            'description'    => 'Rol de Administrador',
    		'special' 	     => 'all-access'
    	]);

        Role::create([
            'name'           => 'Suspendido',
            'slug'           => 'suspendido',
            'description'    => 'Rol de Suspendido'
        ]);

        $user->roles()->sync(1);
    }
}
