<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesSeeder extends Seeder
{
    public function run()
    {
        Role::insert([
            ['name' => 'Petani'],
            ['name' => 'Penyuluh'],
            ['name' => 'Pejabat'],
            ['name' => 'Administrator'],
        ]);
    }
}

