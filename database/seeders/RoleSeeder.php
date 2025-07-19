<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'admin'],
            ['name' => 'user'],
            ['name' => 'owner'],
        ];

        foreach ($roles as $role) {
            \App\Models\Role::updateOrInsert(
                ['name' => $role['name']],
                $role
            );
        }

        $adminRole = \App\Models\Role::where('name', 'admin')->first();

        $adminExists = \App\Models\User::where('role_id', $adminRole->id)->exists();

        if (! $adminExists) {
            \App\Models\User::create([
                'name' => 'Administrator',
                'username' => 'admin',
                'email' => 'admin@example.com',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role_id' => $adminRole->id,
            ]);
        }
    }
}
