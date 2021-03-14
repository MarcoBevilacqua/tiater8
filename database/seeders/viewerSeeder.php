<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Viewer;

class ViewerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        Viewer::factory(5)
        ->create();
    }
}
