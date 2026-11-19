<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ModsSeeder extends Seeder
{
    public function run(): void
    {
        $data = require __DIR__ . '/data_mods.php';
        foreach ($data as $model => $rows) {
            $cls = "App\\Models\\$model";
            $cls::insert(array_map(fn($r) => $r + ['created_at' => now(), 'updated_at' => now()], $rows));
        }
    }
}
