<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Simulate;
use App\Teams;
use App\LeagueTable;
use App\MatchResult;
use Illuminate\Support\Facades\Artisan;

class LeagueController extends Controller
{

    public function index() {
        return view('league.index');
    }

    public function show_tables()
    {
        $latest_week = MatchResult::max('week');
        if ($latest_week == null) {
            $latest_week = 0;
        }
        $league_data = LeagueTable::orderBy('points', 'desc')->get();
        return ['week'=> $latest_week, 'data'=>$league_data];
    }

    public function match_results()
    {
        $result = MatchResult::get();
        
        return $result;
    }

    public function weekly_results( Request $request)
    {
        $week = $request->week;
        $result = MatchResult::where(['week' => $week])->get();
        return $result;
    }

    public function prediction(Request $request)
    {
        $table = Teams::get();
        $league_table = LeagueTable::get();
        //dd( $league_table);
        if($request->week > 4){
            $all_morale = 0;
            foreach($table as $key=>$item){
                $all_morale += $league_table[$key]->points;
            }
           $lfc_percent = (( $league_table[0]->points )/ $all_morale ) * 100;
            $che_percent = (( $league_table[1]->points)/ $all_morale ) * 100;
            $manc_percent = (( $league_table[2]->points)/ $all_morale ) * 100;
            $ars_percent = (( $league_table[3]->points)/ $all_morale ) * 100;
            return [ 'lfc'=> $lfc_percent, 'che' => $che_percent, 'manc'=> $manc_percent, 'ars'=> $ars_percent];
        }
        else{
            return '';
        }
    }

    public function simulate_weekly_res(Request $request)
    {
        $week = $request->week;
       // dd( );
        if (MatchResult::where(['week' => $week])->count() == 0) {
            $simulate = new Simulate();
            $scores = $simulate->week_match_simulate($week);
            $league_table = new LeagueTable();
            $match_res = new MatchResult();
            $match_results = $match_res->insert_result($scores, $week);
            $league_table->insert_league_data($match_results);
            $teams = new Teams();
            $teams->update_data($match_results);
            return 'success';
        }
        
        
    }

    public function simulate_all_res()
    {
        Artisan::call('migrate:fresh --seed');
        $simulate = new Simulate();
        $scores = $simulate->match_simulate();
        $league_table = new LeagueTable();
        $match_res = new MatchResult();
        $match_results = $match_res->all_result($scores);
        $league_table->insert_all_data($match_results);
        $teams = new Teams();
        $teams->update_all_data($match_results);
        return LeagueTable::get();
    }
}
