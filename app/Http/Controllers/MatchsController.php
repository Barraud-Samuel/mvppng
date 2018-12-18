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
        $matchs = Match::orderBy('created_at','asc')->paginate(10);
        $pronostics = Pronostic::all();
        return view('pages.matchs')->with('matchs',$matchs)->with('pronostics',$pronostics);
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
            'match_id'=>'required'
        ]);

        //get current user id
        $user = Auth::user();

        //get match id
        $match_id = $request->input('match_id');

        //get this user for this match id
        $ttestst = Pronostic::where('pronogoalUser_id',$user->id)->get();
        //return $ttestst;

        if (!isset($ttestst)){
            $pronostic  = new Pronostic;
            $pronostic->homeTeam_prono = $request->input('homeTeam_prono');
            $pronostic->awayTeam_prono = $request->input('awayTeam_prono');
            $pronostic->match_id = $request->input('match_id');

            $pronostic ->save();
        }else{
            return "utilisateur deja existant";
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
        //
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
