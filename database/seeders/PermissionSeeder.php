<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'manage_tasks',
            'manage_users',
            'manage_roles',
            'manage_admins',
            'manage_dashboard',
          
        ];

        $timestamp = Carbon::now();

        foreach ($permissions as $permission) {
            DB::table('permissions')->insert([
                'name' => Str::title(str_replace('_', ' ', $permission)), // Human readable name
                'slug' => Str::slug($permission), // Unique identifier
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ]);
        }
    }
}

