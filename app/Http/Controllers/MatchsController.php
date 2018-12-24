<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Match;
use App\Pronostic;
use Illuminate\Support\Facades\Auth;

class MatchsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //$matchs = Match::orderBy('created_at', 'desc')->paginate(10);

        //if match -> over => update the prono to true false


        $user = Auth::user()->id;
        $pronostics = Pronostic::all()->where('pronogoalUser_id','=',$user)->pluck("match_id");
        $allProno = Pronostic::all()->where('pronogoalUser_id','=',$user);
        $allMatch=Match::orderBy('matchday','asc')->paginate(10);
        $matchsWithProno = Match::orderBy('matchday','asc')->whereIn('id',$pronostics)->paginate(10);
        $matchsWhithoutProno = Match::orderBy('matchday','asc')->whereNotIn('id',$pronostics)->paginate(10);
        //return $pronostics;
        //return $user;

        foreach ($allMatch as $match){
            //echo $match;
            //return 12;
            if ($match->status === "FINISHED"){
                $matchId = $match->id;
                $pronosticOver = Pronostic::All()->where('match_id','=',$matchId)->where('pronogoalUser_id','=',$user);
                //echo $match;
                //echo $pronosticOver;
                //return $pronosticOver[1]->homeTeam_prono;
                foreach ($pronosticOver as $pronoOver){
                    if ($pronoOver->homeTeam_prono === $match->result_goalsHomeTeam && $pronoOver->awayTeam_prono === $match->result_goalsAwayTeam){
                        $pronoOver->correct_result = true;
                        $pronoOver ->save();
                    }
                }
            }
        }
        return view('pages.matchs')->with('matchsWithProno',$matchsWithProno)->with('matchsWhithoutProno',$matchsWhithoutProno)->with('allMatch',$allMatch)->with('allProno',$allProno);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'match_id'=>'required',
            'homeTeam_prono'=>'required',
            'awayTeam_prono'=>'required'
        ]);
        //get current user id
        $user = Auth::user();

        //get match id
        $match_id = $request->input('match_id');

        //get this user for this match id
        //$ttestst = Pronostic::where('pronogoalUser_id',$user->id)->get();
        $ttestst = Pronostic::where([
            ['pronogoalUser_id', '=', $user->id],
            ['match_id', '=', $match_id],
        ])->get();

        //return $ttestst;

        if (count($ttestst)>0){
            return redirect ('/matchs')->with('error','Vous avez deja parié pour ce match');

        }else{
            $pronostic  = new Pronostic;
            $pronostic->homeTeam_prono = $request->input('homeTeam_prono');
            $pronostic->awayTeam_prono = $request->input('awayTeam_prono');
            $pronostic->match_id = $request->input('match_id');
            $pronostic->pronogoalUser_id =  Auth::user()->id;

            $pronostic ->save();
            return redirect ('/matchs')->with('success','Score enregistré 😉');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'homeTeam_prono'=>'required',
            'awayTeam_prono'=>'required'
        ]);
        //return $id;

        //enregistration de l'opetration en bdd
        $pronostic = Pronostic::find($id);
        $pronostic->homeTeam_prono = $request->input('homeTeam_prono');
        $pronostic->awayTeam_prono = $request->input('awayTeam_prono');
        //$pronostic->match_id = $request->input('match_id');
        //$pronostic->pronogoalUser_id =  Auth::user()->id;
        $pronostic->save();

        return redirect ('/matchs')->with('success','Score mis a jour 😉');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
