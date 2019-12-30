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
            'name'          => 'Permiso de Entrada a lista de Usuarios',
            'slug'          => 'usuario.index',
            'description'   => 'Lista y Navega todos los usuarios del Sistema'
        ]);
        Permission::create([
            'name'          => 'Permiso de Creacion de Usuarios',
            'slug'          => 'usuario.store',
            'description'   => 'Crear nuevos usuarios en el Sistema'
        ]);
        Permission::create([
            'name'          => 'Permiso de Ver Usuarios',
            'slug'          => 'usuario.show',
            'description'   => 'Ver descripcion de usuarios en el Sistema'
        ]);
        Permission::create([
            'name'          => 'Permiso de Editar Usuarios',
            'slug'          => 'usuario.edit',
            'description'   => 'Editar usuarios del Sistema'
        ]);
        Permission::create([
            'name'          => 'Permiso de Eliminar Usuarios',
            'slug'          => 'usuario.destroy',
            'description'   => 'Eliminar usuarios del Sistema'
        ]);

        //TABLA ROLES
        Permission::create([
            'name'          => 'Permiso de Entrada a lista de Roles',
            'slug'          => 'role.index',
            'description'   => 'Lista y Navega todos los roles del Sistema'
        ]);
        
        Permission::create([
            'name'          => 'Permiso de Creacion de Roles',
            'slug'          => 'role.store',
            'description'   => 'Crear nuevos roles en el Sistema'
        ]);
        Permission::create([
            'name'          => 'Permiso de Ver Roles',
            'slug'          => 'role.show',
            'description'   => 'Ver descripcion de roles en el Sistema'
        ]);
        Permission::create([
            'name'          => 'Permiso de Editar Roles',
            'slug'          => 'role.edit',
            'description'   => 'Editar roles del Sistema'
        ]);
        Permission::create([
            'name'          => 'Permiso de Eliminar Roles',
            'slug'          => 'role.destroy',
            'description'   => 'Eliminar roles del Sistema'
        ]);

        //TABLA Procedimiento
        Permission::create([
            'name'          => 'Permiso de Entrada a lista de Procedimientos',
            'slug'          => 'procedimiento.index',
            'description'   => 'Lista y Navega todos los procedimientos del Sistema'
        ]);
        
        Permission::create([
            'name'          => 'Permiso de Creacion de Procedimiento',
            'slug'          => 'procedimiento.store',
            'description'   => 'Crear nuevos procedimientos en el Sistema'
        ]);
        Permission::create([
            'name'          => 'Permiso de Ver Procedimiento',
            'slug'          => 'procedimiento.show',
            'description'   => 'Ver descripcion de procedimientos en el Sistema'
        ]);
        Permission::create([
            'name'          => 'Permiso de Editar Procedimiento',
            'slug'          => 'procedimiento.edit',
            'description'   => 'Editar procedimientos del Sistema'
        ]);
        Permission::create([
            'name'          => 'Permiso de Eliminar Procedimiento',
            'slug'          => 'procedimiento.destroy',
            'description'   => 'Eliminar procedimientos del Sistema'
        ]);

        //TABLA Expediente
        Permission::create([
            'name'          => 'Permiso de Entrada a lista de Expedientes',
            'slug'          => 'expediente.index',
            'description'   => 'Lista y Navega todos los expedientes del Sistema'
        ]);
        
        Permission::create([
            'name'          => 'Permiso de Creacion de Expedientes',
            'slug'          => 'expediente.store',
            'description'   => 'Crear nuevos expedientes en el Sistema'
        ]);
        Permission::create([
            'name'          => 'Permiso de Ver Expedientes',
            'slug'          => 'expediente.show',
            'description'   => 'Ver descripcion de expedientes en el Sistema'
        ]);
        Permission::create([
            'name'          => 'Permiso de Editar Expedientes',
            'slug'          => 'expediente.edit',
            'description'   => 'Editar expedientes del Sistema'
        ]);
        Permission::create([
            'name'          => 'Permiso de Eliminar Expedientes',
            'slug'          => 'expediente.destroy',
            'description'   => 'Eliminar expedientes del Sistema'
        ]);


        //TABLA Cita
        Permission::create([
            'name'          => 'Permiso de Entrada a lista de Citas',
            'slug'          => 'cita.index',
            'description'   => 'Lista y Navega todos los citas del Sistema'
        ]);
        
        Permission::create([
            'name'          => 'Permiso de Creacion de Citas',
            'slug'          => 'cita.store',
            'description'   => 'Crear nuevos citas en el Sistema'
        ]);
        Permission::create([
            'name'          => 'Permiso de Ver Citas',
            'slug'          => 'cita.show',
            'description'   => 'Ver descripcion de citas en el Sistema'
        ]);
        Permission::create([
            'name'          => 'Permiso de Editar Citas',
            'slug'          => 'cita.edit',
            'description'   => 'Editar citas del Sistema'
        ]);
        Permission::create([
            'name'          => 'Permiso de Eliminar Citas',
            'slug'          => 'cita.destroy',
            'description'   => 'Eliminar citas del Sistema'
        ]);

        //TABLA Receta
        Permission::create([
            'name'          => 'Permiso de Entrada a lista de Recetas',
            'slug'          => 'receta.index',
            'description'   => 'Lista y Navega todos los recetas del Sistema'
        ]);
        
        Permission::create([
            'name'          => 'Permiso de Creacion de Recetas',
            'slug'          => 'receta.store',
            'description'   => 'Crear nuevos recetas en el Sistema'
        ]);
        Permission::create([
            'name'          => 'Permiso de Ver Recetas',
            'slug'          => 'receta.show',
            'description'   => 'Ver descripcion de recetas en el Sistema'
        ]);
        Permission::create([
            'name'          => 'Permiso de Editar Recetas',
            'slug'          => 'receta.edit',
            'description'   => 'Editar recetas del Sistema'
        ]);
        Permission::create([
            'name'          => 'Permiso de Eliminar Recetas',
            'slug'          => 'receta.destroy',
            'description'   => 'Eliminar recetas del Sistema'
        ]);

        //TABLA Pago
        Permission::create([
            'name'          => 'Permiso de Entrada a lista de Pagos',
            'slug'          => 'pago.index',
            'description'   => 'Lista y Navega todos los pagos del Sistema'
        ]);
        
        Permission::create([
            'name'          => 'Permiso de Creacion de Pagos',
            'slug'          => 'pago.store',
            'description'   => 'Crear nuevos pagos en el Sistema'
        ]);
        Permission::create([
            'name'          => 'Permiso de Editar Pagos',
            'slug'          => 'pago.edit',
            'description'   => 'Editar pagos del Sistema'
        ]);
        
    }
}
