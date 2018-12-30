<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Match;
use App\Pronostic;
use App\Results;
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
        //TODO::Faire un refactor du code et modifier le front pour afficher sur si score est bon ou pas (anciennement sur prono) et afficher le score gagné, faire la page de rank

        //Récuperation des elements de la base de donnée
        $user = Auth::user()->id;
        $pronostics = Pronostic::all()->where('pronogoalUser_id','=',$user)->pluck("match_id");
        $allProno = Pronostic::all()->where('pronogoalUser_id','=',$user);
        $allMatch=Match::orderBy('matchday','asc')->paginate(10);
        $matchsWithProno = Match::orderBy('matchday','asc')->whereIn('id',$pronostics)->paginate(10);
        $matchsWhithoutProno = Match::orderBy('matchday','asc')->whereNotIn('id',$pronostics)->paginate(10);
        //return $pronostics;
        //return $user;
        //on boucle sur tous les matchs
        foreach ($allMatch as $match){
            //Si un match est finis
            if ($match->status === "FINISHED"){
                $matchId = $match->id;
                //on recupère le prono du match terminé avec le bon utilisateur
                $pronosticOver = Pronostic::All()->where('match_id','=',$matchId)->where('pronogoalUser_id','=',$user);
                foreach ($pronosticOver as $pronoOver){
                    $result = Results::FindOrfail($pronoOver->id);
                    //return $result;
                    //ATTRIBUTION DES POINTS
                    //score parfait = 5 points
                    //return $match->result_goalsHomeTeam - $match->result_goalsAwayTeam;
                    if ($match->result_goalsHomeTeam === $pronoOver->homeTeam_prono && $match->result_goalsAwayTeam ===  $pronoOver->awayTeam_prono){
                        //si on a le score exact
                        $result->points_score = 5;

                        $result->points_winner = 0;
                        $result->points_difference = 0;
                        $result ->save();
                    }elseif ($match->result_goalsHomeTeam >= $match->result_goalsAwayTeam  && $pronoOver->homeTeam_prono  >=  $pronoOver->awayTeam_prono || $match->result_goalsHomeTeam <= $match->result_goalsAwayTeam  && $pronoOver->homeTeam_prono  <=  $pronoOver->awayTeam_prono ){
                        //si on a le bon gagnant
                        $result->points_winner = 3;

                        $result->points_score = 0;
                        $result->points_difference = 0;
                        $result ->save();
                    }elseif (abs($match->result_goalsHomeTeam - $match->result_goalsAwayTeam) === abs($pronoOver->homeTeam_prono - $pronoOver->awayTeam_prono)){
                        //si on a la bonne diff
                        $result->points_difference = 1;

                        $result->points_score = 0;
                        $result->points_winner = 0;
                        $result ->save();
                    }else{
                        $result->points_score = 0;
                        $result ->save();
                    }
                }
            }
        }
        //affichage de la vue
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

            //quand un prono est creer, on cree aussi un resultat vide que l'on remplira quand le match est fini
            //(par defaut le resultat est faut (0 partout))
            $result = new Results;
            $result->pronostic_id = $pronostic->id;
            $result->pronogoalUser_id =  Auth::user()->id;
            $result->points_score = 0;
            $result->points_difference = 0;
            $result->points_winner = 0;
            $result->save();
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
        //$matchs = Match::orderBy('created_at', 'desc')->paginate(10);

        //Récuperation des elements de la base de donnée
        $user = Auth::user()->id;
        $pronostics = Pronostic::all()->where('pronogoalUser_id','=',$user)->pluck("match_id");
        $allProno = Pronostic::all()->where('pronogoalUser_id','=',$user);
        $allMatch= Match::orderBy('matchday','asc')->where('status','=',$id)->paginate(10);
        $matchsWithProno = Match::orderBy('matchday','asc')->where('status','=',$id)->whereIn('id',$pronostics)->paginate(10);
        $matchsWhithoutProno = Match::orderBy('matchday','asc')->where('status','=',$id)->whereNotIn('id',$pronostics)->paginate(10);
        //return $pronostics;
        //return $user;
        //on boucle sur tous les matchs
        foreach ($allMatch as $match){
            //Si un match est finis
            if ($match->status === "FINISHED"){
                $matchId = $match->id;
                //on recupère le prono du match terminé avec le bon utilisateur
                $pronosticOver = Pronostic::All()->where('match_id','=',$matchId)->where('pronogoalUser_id','=',$user);
                foreach ($pronosticOver as $pronoOver){
                    //recuperation de la table de stockage de scores
                    $result = Results::FindOrfail($pronoOver->id);
                    //ATTRIBUTION DES POINTS
                    //score parfait = 5 points
                    //return $result;
                    if ($match->result_goalsHomeTeam === $pronoOver->homeTeam_prono && $match->result_goalsAwayTeam ===  $pronoOver->awayTeam_prono){
                        //si on a le score exact
                        $result->points_score = 5;

                        $result->points_winner = 0;
                        $result->points_difference = 0;
                        $result ->save();
                    }elseif ($match->result_goalsHomeTeam >= $match->result_goalsAwayTeam  && $pronoOver->homeTeam_prono  >=  $pronoOver->awayTeam_prono || $match->result_goalsHomeTeam <= $match->result_goalsAwayTeam  && $pronoOver->homeTeam_prono  <=  $pronoOver->awayTeam_prono ){
                        //si on a le bon gagnant
                        $result->points_winner = 3;

                        $result->points_score = 0;
                        $result->points_difference = 0;
                        $result ->save();
                    }elseif ($match->result_goalsHomeTeam - $match->result_goalsAwayTeam === $pronoOver->homeTeam_prono  -  $pronoOver->awayTeam_prono){
                        //si on a la bonne diff
                        $result->points_difference = 1;

                        $result->points_score = 0;
                        $result->points_winner = 0;
                        $result ->save();
                    }else{
                        $result->points_score = 0;
                        $result ->save();
                    }
                }
            }
        }
        //affichage de la vue
        return view('pages.matchs')->with('matchsWithProno',$matchsWithProno)->with('matchsWhithoutProno',$matchsWhithoutProno)->with('allMatch',$allMatch)->with('allProno',$allProno);
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
