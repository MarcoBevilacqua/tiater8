<?php

namespace Database\Seeders;

use App\Models\ShowEvent;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            ShowSeeder::class,
            ShowEventSeeder::class,
            //BookingSeeder::class
        ]);
    }
}
