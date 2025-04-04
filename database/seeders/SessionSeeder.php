<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Session;

class SessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    
    public function run()
    {
        Session::factory()->count(10)->create();
    }
}
