<?php

namespace Database\Seeders;

use App\Models\Show;
use App\Models\ShowEvent;
use Illuminate\Database\Seeder;

class ShowEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Show::all()->map(function (Show $show) {
            ShowEvent::factory([
                'show_id' => $show->id
            ])->count(rand(2, 4))->create();
        });
    }
}
