<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Faculty;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
        ]);

        // Admin User
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
        ]);
        $admin->assignRole('Admin');

        // Academic Head User
        $academicHead = User::create([
            'name' => 'Academic Head User',
            'email' => 'academic@gmail.com',
            'password' => bcrypt('password'),
        ]);
        $academicHead->assignRole('Academic Head');

        // Teacher User
        $teacher = User::create([
            'name' => 'Teacher User',
            'email' => 'teacher@gmail.com',
            'password' => bcrypt('password'),
        ]);
        $teacher->assignRole('Teacher');

        // Student User
        $student = User::create([
            'name' => 'Student User',
            'email' => 'student@gmail.com',
            'password' => bcrypt('password'),
        ]);
        $student->assignRole('Student');

        $faculty = Faculty::create([
            'name' => 'Faculty of Science',
        ]);
        Department::create([
            'name' => 'Computer Science',
            'faculty_id' => $faculty->id,
        ]);
    }
}
