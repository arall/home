<?php

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->truncate();

        foreach (Role::all() as $role) {
            $user               = new User();
            $user->role_id      = $role->id;
            $user->status       = 1;
            $user->username     = strtolower($role->name);
            $user->email        = $user->username.'@home.local';
            $user->password     = $user->username;
            $user->confirmed    = 1;
            $user->save();
        }
    }

}
