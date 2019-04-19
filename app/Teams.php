<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Integer;

class Teams extends Model
{
    protected $fillable = ['name','strength','morale'];

    public function update_data($match_results) {
        foreach ($match_results as $res) {
            $team1 = Teams::where(['name' => $res->winning_team])->first();
            $team2 = Teams::where(['name' => $res->losing_team])->first();
            if ($res->goal_difference > 0) {
                $team1->morale = (Integer) $team1->morale + 1;
                $team2->morale = (Integer)$team1->morale - 1;
                $team2->strength = (Integer)$team1->strength - 1;
            } else {
                $team2->morale = (Integer) $team1->morale - 1;
                $team1->morale = (Integer) $team1->morale + 1;
            }
            $team1->save();
            $team2->save();
        }
    }

    public function update_all_data($match_results)
    {
        foreach( $match_results as $results){
            $this->update_data( $results);
        }
    }
}
