<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory([
            'email' => 'dontstop.marco@gmail.com',
            'name' => 'Marco Bevilacqua'
            ])
        ->create();

        User::factory([
            'email' => 'info@piccolacompagniaimpertinente.com',
            'name' => 'Michela Delli Carri'
            ])
        ->create();
    }
}
