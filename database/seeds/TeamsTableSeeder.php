<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Teams;

class TeamsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('teams')->truncate();

        Teams::insert([
                ['name' => 'Liverpool', 'strength' => 97, 'morale' => 50],
                ['name' => 'Chelsea', 'strength' => 96, 'morale' => 50],
                ['name' => 'Manchester City', 'strength' => 98, 'morale' => 50],
                ['name' => 'Arsenal', 'strength' => 95, 'morale' => 50]
            ]
        );
    }
}
