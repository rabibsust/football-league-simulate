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
                ['name' => 'Liverpool', 'strength' => 98, 'morale' => 98],
                ['name' => 'Chelsea', 'strength' => 96, 'morale' => 90],
                ['name' => 'Manchester City', 'strength' => 99, 'morale' => 99],
                ['name' => 'Arsenal', 'strength' => 90, 'morale' => 92]
            ]
        );
    }
}
