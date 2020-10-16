<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'Super Admin']);
        Role::create(['name' => 'Admin Instansi']);
        Role::create(['name' => 'User']);

        $admin = User::create([
            'id'        => '100000000',
            'name'      => 'Developer',
            'email'     => 'developer@dev.com',
            'password'  =>  bcrypt('devpass'),
        ]);
        $admin->assignRole('Super Admin');
        $this->call(ComponentTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(ModelHasRolesTableSeeder::class);
        $this->call(PatientsTableSeeder::class);
    }
}
