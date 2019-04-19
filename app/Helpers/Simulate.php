<?php

namespace App\Helpers;

use App\Teams;

Class Simulate {

    protected function get_match_result($team1, $team2)
    {
        if ($team1->strength > $team2->strength) {
            if ($team1->morale > $team2->morale) {
                $home_advantage = 2;
            } else {
                $home_advantage = 1;
            }
        }
        else {
            if ($team1->morale > $team2->morale) {
                $home_advantage = 3;
            } else {
                $home_advantage = 2;
            }
        }
        $res = ($team1->strength + $team1->morale + $home_advantage) - ( $team2->strength + $team2->morale);
        $i = rand(0,2);
        if ($res < -5) {
            $score = $team1->name.":".(0 + $i) . " - ". (3+$i) .":".$team2->name;
        }
        elseif ($res > -5 && $res<0) {
            $score = $team1->name . ":". (0 + $i) ." - ". (1 + $i) . ":" . $team2->name;
        } 
        elseif ($res > 0 && $res < 3) {
            $score = $team1->name . ":". (0 + $i) . " - ". (0 + $i) . ":" . $team2->name;
        }
        elseif ($res > 3 && $res<5) {
            $score = $team1->name . ":". (1 + $i) . " - ". (0 + $i) . ":" . $team2->name;
        }
        elseif ($res > 5 && $res<8) {
            $score = $team1->name . ":". (2 + $i) ." - ". (0 + $i) . ":" . $team2->name;
        }
        elseif ($res > 8 && $res<10) {
            $score = $team1->name . ":". (3 + $i) . " - ". (0 + $i) . ":" . $team2->name;
        }
        else {
            $score = $team1->name . ":" . (3 + $i) . " - " . (0 + $i) . ":" . $team2->name;
        }

        return $score;
    }

    public function week_match_simulate($week)
    {
        $lfc = Teams::where(['name'=>'Liverpool'])->first();
        $manc = Teams::where([ 'name' => 'Manchester City'])->first();
        $ars = Teams::where([ 'name' => 'Arsenal'])->first();
        $che = Teams::where([ 'name' => 'Chelsea'])->first();
        if ($week == 1) {
            $score1 = $this->get_match_result( $lfc, $che);
            $score2 = $this->get_match_result( $manc, $ars);
        }
        elseif($week == 2) {
            $score1 = $this->get_match_result($che, $manc);
            $score2 = $this->get_match_result($ars, $lfc);
        }
        elseif($week == 3) {
            $score1 = $this->get_match_result( $manc, $lfc);
            $score2 = $this->get_match_result( $che, $ars);
        }
        elseif($week == 4) {
            $score1 = $this->get_match_result( $ars, $che);
            $score2 = $this->get_match_result( $lfc, $manc);
        }
        elseif($week == 5) {
            $score1 = $this->get_match_result( $manc, $che);
            $score2 = $this->get_match_result( $lfc, $ars);
        }
        elseif($week == 6) {
            $score1 = $this->get_match_result( $che, $lfc);
            $score2 = $this->get_match_result($ars, $manc);
        }
        else{
            return false;
        }
        return [$score1, $score2];
    }

    public function match_simulate()
    {
        $all_scores = [];
        for ($i=1; $i < 7; $i++) {
            $all_scores[] = $this->week_match_simulate($i);
        }
        return $all_scores;
    }
}