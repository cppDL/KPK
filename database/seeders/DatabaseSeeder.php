<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course; // Add this import
use App\Models\Module; // Add this if using modules

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Call your specific seeders
        $this->call([
            CourseSeeder::class // This will run your dedicated CourseSeeder
        ]);
    }
}