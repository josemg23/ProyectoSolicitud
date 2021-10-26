<?php

use App\User;
use App\Cuenta;
use App\HistorialCuenta;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        $role2 = Role::create(['name' => 'super-admin', 'description' => 'Super Administrador']);
        $role3 = Role::create(['name' => 'jefe', 'description' => 'Jefe']);
        $role4 = Role::create(['name' => 'director', 'description' => 'Director']);
        $role5 = Role::create(['name' => 'supervisor', 'description' => 'Supervisor']);
        $role6 = Role::create(['name' => 'sub-director', 'description' => 'Sub Director']);
        $role7 = Role::create(['name' => 'coordinador', 'description' => 'Coordinador']);

        Role::create(['name' => 'finanzas', 'description' => 'Finanzas']);
        Role::create(['name' => 'abastecimiento', 'description' => 'Abastecimiento']);
        Role::create(['name' => 'administracion-gestion', 'description' => 'Administracion y Gestion']);

        Role::create(['name' => 'soporte', 'description' => 'Soporte']);
        Role::create(['name' => 'ejecutivo-compras', 'description' => 'Ejecutivo de Compras']);
        Role::create(['name' => 'encargado-convenio', 'description' => 'Encargado de Convenio']);
        Role::create(['name' => 'encargado-mantenimiento', 'description' => 'Encargado de Mantenimientos']);

        Permission::create(['name' => 'usuarios', 'description' => 'Modulo Usuarios']);
        Permission::create(['name' => 'convenios', 'description' => 'Acceso a Convenios']);
        Permission::create(['name' => 'proveedores', 'description' => 'Acceso a Proveedores']);
        Permission::create(['name' => 'cuentas', 'description' => 'Acceso a Cuentas']);
        Permission::create(['name' => 'unidades medidas', 'description' => 'Acceso a Unidades de Medidas']);
        Permission::create(['name' => 'dependencias', 'description' => 'Acceso a Dependencias']);
        Permission::create(['name' => 'departamentos', 'description' => 'Acceso a Departamentos']);
        Permission::create(['name' => 'mantenimiento', 'description' => 'Modulo Mantenimiento']);
        Permission::create(['name' => 'roles', 'description' => 'Acceso a Roles']);

        Permission::create(['name' => 'tipos-contratos', 'description' => 'Acceso a Tipos de Roles']);
        Permission::create(['name' => 'contrato-suministro', 'description' => 'Acceso a Contrato de Suministros']);
        Permission::create(['name' => 'solicitudes', 'description' => 'Modulo de Solicitudes']);
        Permission::create(['name' => 's-contratos suministros', 'description' => 'Acceso a Solicitudes de Contrato de Suministros']);
        Permission::create(['name' => 's-insumos', 'description' => 'Acceso a Solicitudes de Insumos y Servicios']);
        Permission::create(['name' => 's-convenios', 'description' => 'Acceso a Solicitudes de Convenio']);
        Permission::create(['name' => 's-mantenimientos', 'description' => 'Acceso a Solicitudes de Mantenimiento']);

        Permission::create(['name' => 'evaluaciones', 'description' => 'Modulo de Evaluaciones']);
        Permission::create(['name' => 'e-contratos suministros', 'description' => 'Acceso a Evaluaciones de Contrato de Suministros']);
        Permission::create(['name' => 'e-insumos', 'description' => 'Acceso a Evaluaciones de Insumos y Servicios']);
        Permission::create(['name' => 'e-convenios', 'description' => 'Acceso a Evaluaciones de Convenios']);
        Permission::create(['name' => 'e-mantenimientos', 'description' => 'Acceso a Evaluaciones de Mantenimiento']);
        Permission::create(['name' => 'abastecimiento', 'description' => 'Modulo Abastecimiento']);
        Permission::create(['name' => 'ordenes', 'description' => 'Acceso a Ordenes de Compras']);
        Permission::create(['name' => 'decretos', 'description' => 'Acceso a Decretos de Adjudicación']);
        Permission::create(['name' => 'recepciones', 'description' => 'Modulo Recepciones']);
        Permission::create(['name' => 'r-solicitudes', 'description' => 'Acceso Lista de Solicitudes Recepcionadas']);
        Permission::create(['name' => 'r-evaluacion-finanzas', 'description' => 'Acceso Evaluacion de Recepciones - Finanzas']);
        Permission::create(['name' => 'r-evaluacion-abastecimiento', 'description' => 'Acceso Evaluacion de Recepciones - Abastecimiento']);
        Permission::create(['name' => 'rechazos', 'description' => 'Modulo Tipos de Rechazo']);
        Permission::create(['name' => 'criterios', 'description' => 'Modulo Criterios de Adjudicación']);
        Permission::create(['name' => 'expedientes', 'description' => 'Modulo Expedientes de Pago']);
        Permission::create(['name' => 'editar-solicitud', 'description' => 'Editar Monto en Solicitudes']);
        Permission::create(['name' => 'editar-monto', 'description' => 'Editar Montos de Adjudicación']);
        DB::table('users')->insert([
            'username'        => 'administrador',
            'nombres'         => 'Jonas',
            'email'           => 'admin@admin.com',
            'password'        => Hash::make('12345678'),
            'estado'          => 'activo',
            'created_at'      => now(),
            'updated_at'      => now()
        ]);
        $user = User::find(1);
        $user->assignRole($role2);

        DB::table('dependencias')->insert([
            'nombre'          => 'CESFAM- CRISTOBAL SAENZ CERDA',
            'estado'          => 'activo',
            'created_at'      => now(),
            'updated_at'      => now()
        ]);


        DB::table('departamentos')->insert([
            'nombre'          => 'DIRECCIÓN',
            'estado'          => 'activo',
            'dependencia_id'  => 1,
            'created_at'      => now(),
            'updated_at'      => now()
        ]);

        DB::table('users')->insert([

            'username'        => 'finanzas',
            'nombres'         => 'Finanzas',
            'email'           => 'finanzas@finanzas.com',
            'departamento_id'           => 1,
            'password'        => Hash::make('12345678'),
            'estado'          => 'activo',
            'created_at'      => now(),
            'updated_at'      => now()
        ]);
        $user1 = User::find(2);
        $user1->assignRole('finanzas');


        DB::table('users')->insert([

            'username'        => 'abastecimiento',
            'nombres'         => 'Abastecimiento',
            'email'           => 'abastecimiento@abastecimiento.com',
            'departamento_id'           => 1,
            'password'        => Hash::make('12345678'),
            'estado'          => 'activo',
            'created_at'      => now(),
            'updated_at'      => now()
        ]);
        $user2 = User::find(3);
        $user2->assignRole('abastecimiento');

        DB::table('users')->insert([

            'username'        => 'admin-gestion',
            'nombres'         => 'Administración & Gestion',
            'email'           => 'admin@gestion.com',
            'departamento_id'           => 1,
            'password'        => Hash::make('12345678'),
            'estado'          => 'activo',
            'created_at'      => now(),
            'updated_at'      => now()
        ]);
        $user3 = User::find(4);
        $user3->assignRole('administracion-gestion');

        DB::table('users')->insert([

            'username'        => 'ejecutivo',
            'nombres'         => 'Ejecutivo de Compras',
            'email'           => 'ejecutivo@gestion.com',
            'departamento_id'           => 1,
            'password'        => Hash::make('12345678'),
            'estado'          => 'activo',
            'created_at'      => now(),
            'updated_at'      => now()
        ]);
        $user4 = User::find(5);
        $user4->assignRole('ejecutivo-compras');

        DB::table('users')->insert([

            'username'        => 'encargado-convenio',
            'nombres'         => 'Encargado de Convenio',
            'email'           => 'encargado@convenio.com',
            'departamento_id'           => 1,
            'password'        => Hash::make('12345678'),
            'estado'          => 'activo',
            'created_at'      => now(),
            'updated_at'      => now()
        ]);
        $user5 = User::find(6);
        $user5->assignRole('encargado-convenio');

        DB::table('users')->insert([

            'username'        => 'director',
            'nombres'         => 'Director',
            'email'           => 'director@director.com',
            'departamento_id' => 1,
            'password'        => Hash::make('12345678'),
            'estado'          => 'activo',
            'created_at'      => now(),
            'updated_at'      => now()
        ]);
        $user6 = User::find(7);
        $user6->assignRole('director');

        DB::table('cuentas')->insert([

            'nombre'      => '8752425525625',
            'descripcion' => 'CAJA',
            'saldo_i'     => 500000.00,
            'saldo_a'     => 500000.00,
            'estado'      => 'activo',
            'created_at'  => now(),
            'updated_at'  => now()
        ]);

        $c = Cuenta::find(1);
        $detalle = "Saldo Inicial Agregado";
        $historial    = new HistorialCuenta(['cuenta_id' => $c->id, 'detalle' => $detalle, 'cantidad' =>  $c->saldo_i, 'type' => 'ingreso']);
        $c->historiales()->save($historial);

        DB::table('cuentas')->insert([

            'nombre'      => '875963254',
            'descripcion' => 'BANCO',
            'saldo_i'     => 80000.00,
            'saldo_a'     => 80000.00,
            'estado'      => 'activo',
            'created_at'  => now(),
            'updated_at'  => now()
        ]);
        $c = Cuenta::find(2);
        $detalle = "Saldo Inicial Agregado";
        $historial    = new HistorialCuenta(['cuenta_id' => $c->id, 'detalle' => $detalle, 'cantidad' =>  $c->saldo_i, 'type' => 'ingreso']);
        $c->historiales()->save($historial);
        DB::table('cuentas')->insert([

            'nombre'      => '9652263652',
            'descripcion' => 'VEHICULOS',
            'saldo_i'     => 500000.00,
            'saldo_a'     => 500000.00,
            'estado'      => 'activo',
            'created_at'  => now(),
            'updated_at'  => now()
        ]);

        $c = Cuenta::find(3);
        $detalle = "Saldo Inicial Agregado";
        $historial    = new HistorialCuenta(['cuenta_id' => $c->id, 'detalle' => $detalle, 'cantidad' =>  $c->saldo_i, 'type' => 'ingreso']);
        $c->historiales()->save($historial);
        DB::table('cuentas')->insert([

            'nombre'      => '444452222',
            'descripcion' => 'MUEBLES DE OFICINA',
            'saldo_i'     => 800000.00,
            'saldo_a'     => 800000.00,
            'estado'      => 'activo',
            'created_at'  => now(),
            'updated_at'  => now()
        ]);

        $c = Cuenta::find(4);
        $detalle = "Saldo Inicial Agregado";
        $historial    = new HistorialCuenta(['cuenta_id' => $c->id, 'detalle' => $detalle, 'cantidad' =>  $c->saldo_i, 'type' => 'ingreso']);
        $c->historiales()->save($historial);
        DB::table('medidas')->insert([

            'nombre'      => 'UNIDAD',
            'estado'      => 'activo',
            'created_at'  => now(),
            'updated_at'  => now()
        ]);
        DB::table('tipo_contratos')->insert([

            'nombre'      => 'ASEO',
            'descripcion' => 'Contrato de Aseo',
            'estado'      => 'activo',
            'created_at'  => now(),
            'updated_at'  => now()
        ]);

        DB::table('proveedors')->insert([
            'nombre'     => 'GARCES CASANELLI LIMITADA',
            'rut'        => '76.415.442-8',
            'direccion'  => 'FERRETERIA Y VENTA DE MATERIALES DE CONSTRUCCION',
            'giro'       => 'FERRETERIA Y VENTA DE MATERIALES DE CONSTRUCCION',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('products')->insert([
            'nombre'       => 'AJAX CLORO',
            'detalle'      => 'DETALLE 1',
            'valor'        => 50000.00,
            'proveedor_id' => 1,
            'medida_id'    => 1,
            'tipo_contrato_id' => 1,
            'created_at'   => now(),
            'updated_at'   => now()
        ]);
        DB::table('products')->insert([
            'nombre'       => 'DETERGENTE DEJA',
            'detalle'      => 'DETALLE 2',
            'valor'        => 80000.00,
            'proveedor_id' => 1,
            'medida_id'    => 1,
            'tipo_contrato_id' => 1,
            'created_at'   => now(),
            'updated_at'   => now()
        ]);
        DB::table('products')->insert([
            'nombre'       => 'DESINFECTANTE OLIMPIA',
            'detalle'      => 'DETALLE 2',
            'valor'        => 80000.00,
            'proveedor_id' => 1,
            'medida_id'    => 1,
            'tipo_contrato_id' => 1,
            'created_at'   => now(),
            'updated_at'   => now()
        ]);
    }
}
