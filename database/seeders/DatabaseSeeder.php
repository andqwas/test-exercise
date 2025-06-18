<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Role;
use App\Models\Task;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Employee::factory(20)->create();
        Task::factory(200)->create();

        $roles = [
            ['name' => 'programmer', 'title' => 'Программист'],
            ['name' => 'manager', 'title' => 'Менеджер']
        ];

        foreach ($roles as $role) {
            Role::factory()->create($role);
        }
    }
}
