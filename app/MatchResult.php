<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Integer;

class MatchResult extends Model
{
    protected $fillable = [ 'wining_team', 'losing_team', 'week', 'goal_difference', 'result'];

    public function insert_result($scores,$week){
        $winner1='';
        $loser1='';
        $winner2='';
        $loser2='';
        $score1 = $scores[0];
        $score2 = $scores[1];
        $score1 = explode(":", $score1);
        $score2 = explode(":", $score2);
        $res_1 = $score1[1];
        $res_2 = $score2[1];
        $team1 = $score1[0];
        $team2 = $score1[2];
        $team3 = $score2[0];
        $team4 = $score2[2];
        $score_1 = explode("-", $res_1);
        $score_2 = explode("-", $res_2);
        $score_1[0] = (Integer)$score_1[0];
        $score_1[1] = (Integer)$score_1[1];
        $score_2[0] = (Integer)$score_2[0];
        $score_2[1] = (Integer)$score_2[1];
        //dd( $score_1, $score2);
        $goal_diff1 = abs( $score_1[0] - $score_1[1]);
        $goal_diff2 = abs($score_2[0] - $score_2[1]);
        
        if( $score_1[0]> $score_1[1]){
            $winner1 = $team1;
            $loser1 = $team2;
        }
        else if( $score_1[0] < $score_1[1]){
            $winner1 = $team2;
            $loser1 = $team1;
        }
        else {
            $winner1 = $team2;
            $loser1 = $team1;
        }

        if( $score_2[0]> $score_2[1]){
            $winner2 = $team3;
            $loser2 = $team4;
        }
        else if( $score_2[0] < $score_2[1]){
            $winner2 = $team4;
            $loser2 = $team3;
        }
        else {
            $winner2 = $team4;
            $loser2 = $team3;
        }
        MatchResult::insert([
            ['winning_team'=> $winner1, 'losing_team'=> $loser1, 'week'=> $week, 'goal_difference'=>$goal_diff1, 'result'=>$res_1],
            ['winning_team'=> $winner2, 'losing_team'=> $loser2, 'week'=> $week, 'goal_difference'=>$goal_diff2, 'result'=>$res_2],
        ]);
        $result = MatchResult::where(['week'=> $week])->get();
        return $result;
    }

    public function all_result($scores)
    {
        $all_result = [];
        foreach($scores as $key=>$score){
            $all_result[] = $this->insert_result( $score, $key);
        }
        return $all_result;
    }
}
