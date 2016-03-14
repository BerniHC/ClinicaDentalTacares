<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
        Eloquent::unguard();

        Metagroup::create(array('description' => 'Tipos de Documentos'));
        Metagroup::create(array('description' => 'Géneros'));
        Metagroup::create(array('description' => 'Tipos de Pacientes'));
        Metagroup::create(array('description' => 'Prioridades de Eventos'));
        Metagroup::create(array('description' => 'Estados de las citas'));

		Metatype::create(array('metagroup_id' => '1', 'description' => 'Cédula de Identidad'));
		Metatype::create(array('metagroup_id' => '1', 'description' => 'Cédula de Residencia'));
		Metatype::create(array('metagroup_id' => '1', 'description' => 'Pasaporte'));
		Metatype::create(array('metagroup_id' => '2', 'description' => 'Masculino'));
		Metatype::create(array('metagroup_id' => '2', 'description' => 'Femenino'));
		Metatype::create(array('metagroup_id' => '3', 'description' => 'Becado'));
		Metatype::create(array('metagroup_id' => '3', 'description' => 'Comunidad'));
		Metatype::create(array('metagroup_id' => '3', 'description' => 'Escolar'));
		Metatype::create(array('metagroup_id' => '4', 'description' => 'Normal'));
		Metatype::create(array('metagroup_id' => '4', 'description' => 'Media'));
		Metatype::create(array('metagroup_id' => '4', 'description' => 'Alta'));
		Metatype::create(array('metagroup_id' => '5', 'description' => 'Asignada'));
		Metatype::create(array('metagroup_id' => '5', 'description' => 'Atendido'));
		Metatype::create(array('metagroup_id' => '5', 'description' => 'Ausente'));
		Metatype::create(array('metagroup_id' => '5', 'description' => 'Cancelado'));

		Estate::create(array('name' => 'Alajuela'));
		Estate::create(array('name' => 'Cartago'));
		Estate::create(array('name' => 'Guanacaste'));
		Estate::create(array('name' => 'Heredia'));
		Estate::create(array('name' => 'Limón'));
		Estate::create(array('name' => 'Puntarenas'));
		Estate::create(array('name' => 'San José'));
        
		City::create(array('name' => 'Alajuela', 'estate_id' => '1'));
		City::create(array('name' => 'Grecia', 'estate_id' => '1'));
		City::create(array('name' => 'Poás', 'estate_id' => '1'));
		City::create(array('name' => 'Sarchí', 'estate_id' => '1'));
		City::create(array('name' => 'Tacares', 'estate_id' => '1'));
		City::create(array('name' => 'San Ramón', 'estate_id' => '1'));
		City::create(array('name' => 'San Mateo', 'estate_id' => '1'));
		City::create(array('name' => 'Atenas', 'estate_id' => '1'));
		City::create(array('name' => 'Naranjo', 'estate_id' => '1'));
		City::create(array('name' => 'Palmares', 'estate_id' => '1'));
		City::create(array('name' => 'San Pedro', 'estate_id' => '1'));
		City::create(array('name' => 'Cartago', 'estate_id' => '2'));
		City::create(array('name' => 'Paraíso', 'estate_id' => '2'));
		City::create(array('name' => 'La Unión', 'estate_id' => '2'));
		City::create(array('name' => 'Liberia', 'estate_id' => '3'));
		City::create(array('name' => 'Nicoya', 'estate_id' => '3'));
		City::create(array('name' => 'Santa Cruz', 'estate_id' => '3'));
		City::create(array('name' => 'Heredia', 'estate_id' => '4'));
		City::create(array('name' => 'Barva', 'estate_id' => '4'));
		City::create(array('name' => 'Santo Domingo', 'estate_id' => '4'));
		City::create(array('name' => 'Limón', 'estate_id' => '5'));
		City::create(array('name' => 'Pococí', 'estate_id' => '5'));
		City::create(array('name' => 'Siquirres', 'estate_id' => '5'));
		City::create(array('name' => 'Puntarenas', 'estate_id' => '6'));
		City::create(array('name' => 'Esparza', 'estate_id' => '6'));
		City::create(array('name' => 'Buenos Aires', 'estate_id' => '6'));
		City::create(array('name' => 'San José', 'estate_id' => '7'));
		City::create(array('name' => 'Escazú', 'estate_id' => '7'));
		City::create(array('name' => 'Desamparados', 'estate_id' => '7'));
        
		Category::create(array('description' => 'Diagnóstico', 'color' => '#5D9CEC'));
		Category::create(array('description' => 'Endodoncia', 'color' => '#48CFAD'));
		Category::create(array('description' => 'Exodoncia y Cirugía', 'color' => '#FC6E51'));
		Category::create(array('description' => 'Ortodoncia', 'color' => '#FFCE54'));
		Category::create(array('description' => 'Promoción de la Salud', 'color' => '#A0D468'));
		Category::create(array('description' => 'Restaurativa', 'color' => '#AC92EC'));

        Treatment::create(array('description' => 'Exámenes clínicos', 'category_id' => 1));
        Treatment::create(array('description' => 'Control de Placa', 'category_id' => 1));
        Treatment::create(array('description' => 'Instr. Fisioterapia', 'category_id' => 1));
        Treatment::create(array('description' => 'Profilaxis', 'category_id' => 1));
        Treatment::create(array('description' => 'Aplic. flúor', 'category_id' => 1));
        Treatment::create(array('description' => 'Radiografías', 'category_id' => 1));
        Treatment::create(array('description' => 'Tratamiento de Endodoncia', 'category_id' => 2));
        Treatment::create(array('description' => 'Valoración de Cirugía', 'category_id' => 3));
        Treatment::create(array('description' => 'Sellantes fosas y fisuras', 'category_id' => 3));
        Treatment::create(array('description' => 'Exodoncia/caries', 'category_id' => 3));
        Treatment::create(array('description' => 'Exodoncia/Orto', 'category_id' => 3));
        Treatment::create(array('description' => 'Cirugía', 'category_id' => 3));
        Treatment::create(array('description' => 'Eliminación sutura', 'category_id' => 3));
        Treatment::create(array('description' => 'Valoración Ortodoncia', 'category_id' => 4));
        Treatment::create(array('description' => 'Coloc de Aparatos', 'category_id' => 4));
        Treatment::create(array('description' => 'Eliminación aparatos', 'category_id' => 4));
        Treatment::create(array('description' => 'Controles de Orto', 'category_id' => 4));
        Treatment::create(array('description' => 'Mantenedor de espacio', 'category_id' => 4));
        Treatment::create(array('description' => 'Tomas de impresión', 'category_id' => 4));
        Treatment::create(array('description' => 'Hyrax', 'category_id' => 4));
        Treatment::create(array('description' => 'Charlas Educ. Ind.', 'category_id' => 5));
        Treatment::create(array('description' => 'Charlas Educ. Colec.', 'category_id' => 5));
        Treatment::create(array('description' => 'Óxidos', 'category_id' => 6));
        Treatment::create(array('description' => 'Amalgamas', 'category_id' => 6));
        Treatment::create(array('description' => 'Resinas Preventivas', 'category_id' => 6));
        Treatment::create(array('description' => 'Resinas', 'category_id' => 6));
        Treatment::create(array('description' => 'Pulpotomías', 'category_id' => 6));
        Treatment::create(array('description' => 'Raspados', 'category_id' => 6));
        Treatment::create(array('description' => 'Ionomeros Vidrio', 'category_id' => 6));
        Treatment::create(array('description' => 'I.R.M', 'category_id' => 6));

        Role::create(array('name' => 'Administrador'));
        Role::create(array('name' => 'Doctor'));
        Role::create(array('name' => 'Estudiante'));

        Permission::create(array('name' => 'view-calendar', 'display_name' => 'Ver calendario'));

        Permission::create(array('name' => 'export-appointments', 'display_name' => 'Exportar citas'));
        Permission::create(array('name' => 'list-appointments', 'display_name' => 'Listar citas'));
        Permission::create(array('name' => 'add-appointments', 'display_name' => 'Agregar citas'));
        Permission::create(array('name' => 'edit-appointments', 'display_name' => 'Editar citas'));
        Permission::create(array('name' => 'view-appointments', 'display_name' => 'Ver citas'));
        Permission::create(array('name' => 'delete-appointments', 'display_name' => 'Eliminar citas'));
        
        Permission::create(array('name' => 'export-patients', 'display_name' => 'Exportar pacientes'));
        Permission::create(array('name' => 'list-patients', 'display_name' => 'Listar pacientes'));
        Permission::create(array('name' => 'add-patients', 'display_name' => 'Agregar pacientes'));
        Permission::create(array('name' => 'edit-patients', 'display_name' => 'Editar pacientes'));
        Permission::create(array('name' => 'view-patients', 'display_name' => 'Ver pacientes'));
        Permission::create(array('name' => 'delete-patients', 'display_name' => 'Eliminar pacientes'));

        Permission::create(array('name' => 'export-users', 'display_name' => 'Exportar usuarios'));
        Permission::create(array('name' => 'list-users', 'display_name' => 'Listar usuarios'));
        Permission::create(array('name' => 'add-users', 'display_name' => 'Agregar usuarios'));
        Permission::create(array('name' => 'edit-users', 'display_name' => 'Editar usuarios'));
        Permission::create(array('name' => 'view-users', 'display_name' => 'Ver usuarios'));
        Permission::create(array('name' => 'delete-users', 'display_name' => 'Eliminar usuarios'));
        
        Permission::create(array('name' => 'add-addresses', 'display_name' => 'Agregar direcciones'));
        Permission::create(array('name' => 'delete-addresses', 'display_name' => 'Eliminar direcciones'));
        
        Permission::create(array('name' => 'add-telephones', 'display_name' => 'Agregar teléfonos'));
        Permission::create(array('name' => 'delete-telephones', 'display_name' => 'Eliminar teléfonos'));

        Permission::create(array('name' => 'list-events', 'display_name' => 'Listar eventos'));
        Permission::create(array('name' => 'add-events', 'display_name' => 'Agregar eventos'));
        Permission::create(array('name' => 'edit-events', 'display_name' => 'Editar eventos'));
        Permission::create(array('name' => 'view-events', 'display_name' => 'Ver eventos'));
        Permission::create(array('name' => 'delete-events', 'display_name' => 'Eliminar eventos'));
        
        Permission::create(array('name' => 'list-roles', 'display_name' => 'Listar roles'));
        Permission::create(array('name' => 'add-roles', 'display_name' => 'Agregar roles'));
        Permission::create(array('name' => 'edit-roles', 'display_name' => 'Editar roles'));
        Permission::create(array('name' => 'view-roles', 'display_name' => 'Ver roles'));
        Permission::create(array('name' => 'delete-roles', 'display_name' => 'Eliminar roles'));
        
        Permission::create(array('name' => 'list-metatypes', 'display_name' => 'Listar Metatipos'));
        Permission::create(array('name' => 'add-metatypes', 'display_name' => 'Agregar Metatipos'));
        Permission::create(array('name' => 'edit-metatypes', 'display_name' => 'Editar Metatipos'));
        Permission::create(array('name' => 'delete-metatypes', 'display_name' => 'Eliminar Metatipos'));
        
        Permission::create(array('name' => 'list-treatments', 'display_name' => 'Listar Tratamientos'));
        Permission::create(array('name' => 'add-treatments', 'display_name' => 'Agregar Tratamientos'));
        Permission::create(array('name' => 'edit-treatments', 'display_name' => 'Editar Tratamientos'));
        Permission::create(array('name' => 'delete-treatments', 'display_name' => 'Eliminar Tratamientos'));
        
        Permission::create(array('name' => 'config-system', 'display_name' => 'Configurar Sistema'));
        
        $role = Role::find(1);
        $role->perms()->sync(Permission::lists('id'));
        $role->save();

	}

}
