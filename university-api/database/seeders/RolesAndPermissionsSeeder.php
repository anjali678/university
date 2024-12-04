<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles and assign permissions
        $admin = Role::create(['name' => 'Admin']);
        $academicHead = Role::create(['name' => 'Academic Head']);
        $teacher = Role::create(['name' => 'Teacher']);
        $student = Role::create(['name' => 'Student']);

        // Create permissions
        Permission::create(['name' => 'create course']);
        Permission::create(['name' => 'update course']);
        Permission::create(['name' => 'view course']);
        Permission::create(['name' => 'delete course']);

        Permission::create(['name' => 'create module']);
        Permission::create(['name' => 'update module']);
        Permission::create(['name' => 'view module']);
        Permission::create(['name' => 'delete module']);

        Permission::create(['name' => 'create syllabus']);
        Permission::create(['name' => 'update syllabus']);
        Permission::create(['name' => 'view syllabus']);
        Permission::create(['name' => 'delete syllabus']);

        Permission::create(['name' => 'create semester']);
        Permission::create(['name' => 'update semester']);
        Permission::create(['name' => 'view semester']);
        Permission::create(['name' => 'delete semester']);

        $admin->givePermissionTo(Permission::all());
        $academicHead->givePermissionTo([
            'create course', 'update course', 'view course', 'delete course',
            'create module', 'update module', 'view module', 'delete module',
            'create syllabus', 'update syllabus', 'view syllabus', 'delete syllabus',
            'create semester', 'update semester', 'view semester', 'delete semester'
        ]);
        $teacher->givePermissionTo([
            'view course', 'view module', 'view syllabus', 'view semester'
        ]);
        $student->givePermissionTo([
            'view course', 'view module', 'view syllabus', 'view semester'
        ]);
    }
}
