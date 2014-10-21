<?php

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('roles')->delete();

        // Admin User
        $role = new Role;
        $role->name = 'Admin';
        $role->save();

        // Registgered User
        $role = new Role;
        $role->name = 'Registered';
        $role->save();
    }

}
