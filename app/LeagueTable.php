<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeagueTable extends Model
{
    protected $fillable = ['name', 'points', 'played', 'win', 'draw', 'goal_difference'];
    public $timestamp = false;
    public function insert_league_data( $match_results)
    {
        $res1 = $match_results[0];
        $res2 = $match_results[1];
        $this->insert_data($res1);
        $this->insert_data($res2);
    }
    protected function insert_data($res)
    {
        if ($res->goal_difference > 0) {
            $winner = LeagueTable::where(['name' => $res->winning_team])->first();
            $loser = LeagueTable::where(['name' => $res->losing_team])->first();
            if (empty($winner)) {
                $winner = new LeagueTable();
                $winner->points = 3;
                $winner->played = 1;
                $winner->win = 1;
                $winner->draw = 0;
                $winner->goal_difference = (Integer)$res->goal_difference;
            } else {
                $winner->points = (Integer)$winner->points + 3;
                $winner->played = (Integer)$winner->played + 1;
                $winner->win = (Integer)$winner->win + 1;
                $winner->draw = (Integer)$winner->draw;
                $winner->goal_difference = (Integer)$winner->goal_difference + (Integer)$res->goal_difference;
            }
            if ( empty($loser)) {
                $loser = new LeagueTable();
                $loser->points = 0;
                $loser->played = 1;
                $loser->win = 0;
                $loser->draw = 0;
                $loser->goal_difference = 0 - (Integer)$res->goal_difference;
            } else {
                $loser->points = (Integer)$loser->points;
                $loser->win = $loser->win;
                $loser->draw = $loser->draw;
                $loser->played = (Integer)$loser->played + 1;
                $loser->goal_difference = (Integer)$loser->goal_difference - (Integer)$res->goal_difference;
            }
            $winner->name = $res->winning_team;
            $loser->name = $res->losing_team;
            $winner->save();
            $loser->save();
        } else {
            $team1 = LeagueTable::where(['name' => $res->winning_team])->first();
            $team2 = LeagueTable::where(['name' => $res->losing_team])->first();
            if (empty($team1)) {
                $team1 = new LeagueTable();
                $team1->points = 1;
                $team1->played = 1;
                $team1->win = 0;
                $team1->draw = 1;
                $team1->goal_difference = (Integer)$res->goal_difference;
            } else {
                $team1->points = (Integer)$team1->points + 1;
                $team1->played = (Integer)$team1->played + 1;
                $team1->win = (Integer)$team2->win;
                $team1->draw = (Integer)$team1->draw + 1;
                $team1->goal_difference = (Integer)$team1->goal_difference + (Integer)$res->goal_difference;
            }
            if (empty($team2)) {
                $team2 = new LeagueTable();
                $team2->points = 1;
                $team2->played = 1;
                $team2->win = 0;
                $team2->draw = 1;
                $team2->goal_difference = (Integer)$res->goal_difference;
            } else {
                $team2->points = (Integer)$team2->points + 1;
                $team2->played = (Integer)$team2->played + 1;
                $team2->win = (Integer)$team2->win;
                $team2->draw = (Integer)$team2->draw + 1;
                $team2->goal_difference = (Integer)$team2->goal_difference + (Integer)$res->goal_difference;
            }
            $team1->name = $res->winning_team;
            $team2->name = $res->losing_team;
            $team1->save();
            $team2->save();
        }
    }

    public function insert_all_data( $match_results)
    {
        
        foreach( $match_results as $results){
            $this->insert_league_data( $results);
        }
    }
}
