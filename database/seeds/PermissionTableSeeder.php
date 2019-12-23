<?php

use Illuminate\Database\Seeder;
use Caffeinated\Shinobi\Models\Permission;
class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //TABLA USER
        Permission::create([
            'name'         => 'Permiso de Entrada a lista de Usuarios',
            'slug'         => 'user.index',
            'description'  => 'Lista y Navega todos los usuarios del Sistema'
        ]);
        Permission::create([
            'name' => 'Permiso de Creacion de Usuarios',
            'slug' => 'user.store',
            'description' => 'Crear nuevos usuarios en el Sistema'
        ]);
        Permission::create([
            'name' => 'Permiso de Ver Usuarios',
            'slug' => 'user.show',
            'description' => 'Ver descripcion de usuarios en el Sistema'
        ]);
        Permission::create([
            'name' => 'Permiso de Editar Usuarios',
            'slug' => 'user.edit',
            'description' => 'Editar usuarios del Sistema'
        ]);
        Permission::create([
            'name' => 'Permiso de Eliminar Usuarios',
            'slug' => 'user.destroy',
            'description' => 'Eliminar usuarios del Sistema'
        ]);

        //TABLA ROLES
        Permission::create([
            'name' => 'Permiso de Entrada a lista de Roles',
            'slug' => 'rol.index',
            'description' => 'Lista y Navega todos los roles del Sistema'
        ]);
        
        Permission::create([
            'name' => 'Permiso de Creacion de Roles',
            'slug' => 'rol.store',
            'description' => 'Crear nuevos roles en el Sistema'
        ]);
        Permission::create([
            'name' => 'Permiso de Ver Roles',
            'slug' => 'rol.show',
            'description' => 'Ver descripcion de roles en el Sistema'
        ]);
        Permission::create([
            'name' => 'Permiso de Editar Roles',
            'slug' => 'rol.edit',
            'description' => 'Editar roles del Sistema'
        ]);
        Permission::create([
            'name' => 'Permiso de Eliminar Roles',
            'slug' => 'rol.destroy',
            'description' => 'Eliminar roles del Sistema'
        ]);

        //TABLA ROLES
        Permission::create([
            'name' => 'Permiso de Entrada a lista de Procedimientos',
            'slug' => 'procedimiento.index',
            'description' => 'Lista y Navega todos los procedimientos del Sistema'
        ]);
        
        Permission::create([
            'name' => 'Permiso de Creacion de Procedimiento',
            'slug' => 'procedimiento.store',
            'description' => 'Crear nuevos procedimientos en el Sistema'
        ]);
        Permission::create([
            'name' => 'Permiso de Ver Procedimiento',
            'slug' => 'procedimiento.show',
            'description' => 'Ver descripcion de procedimientos en el Sistema'
        ]);
        Permission::create([
            'name' => 'Permiso de Editar Procedimiento',
            'slug' => 'procedimiento.edit',
            'description' => 'Editar procedimientos del Sistema'
        ]);
        Permission::create([
            'name' => 'Permiso de Eliminar Procedimiento',
            'slug' => 'procedimiento.destroy',
            'description' => 'Eliminar procedimientos del Sistema'
        ]);
    }
}
