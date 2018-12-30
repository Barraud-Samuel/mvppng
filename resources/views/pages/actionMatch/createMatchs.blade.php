<div class="card text-center mt-4">
    <div class="card-title bg-dark">
        <p class="pt-3 text-white">jour de la competition : {{$matchWhithoutProno->matchday}}
            <span class="{{($matchWhithoutProno->status == 'INCOMMING')?'badge-warning badge ' : (($matchWhithoutProno->status == 'RUNNING')?'badge-success badge ':'badge badge-primary                                               ')}}">
                        {{($matchWhithoutProno->status == 'INCOMMING')?'à venir' : (($matchWhithoutProno->status == 'RUNNING')?'en cours':'terminé')}}
                    </span>
        </p>
    </div>
{!! Form::open(['action' => 'MatchsController@store','method'=>'POST','class'=>'row']) !!}
<div class="col-5">
    <p>{{$matchWhithoutProno->homeTeamName}}</p>
    <p>{{$matchWhithoutProno->result_goalsHomeTeam}}</p>
    <div class="form-group px-5">
        {{Form::label('homeTeam_prono','score')}}
        {{Form::number('homeTeam_prono','',['class'=>'form-control','placeholder'=>'score'])}}
    </div>
</div>

<div class="col-2">
    <p></p>
    <p>vs</p>
    {{Form::submit('Enregistrer',['class'=>'btn btn-primary my-2'])}}
</div>

<div class="col-5">
    <p>{{$matchWhithoutProno->awayTeamName}}</p>
    <p>{{$matchWhithoutProno->result_goalsAwayTeam}}</p>
    <div class="form-group px-5">
        {{Form::label('homeTeam_prono','score')}}
        {{Form::number('awayTeam_prono','',['class'=>'form-control','placeholder'=>'score'])}}
        {{Form::hidden('match_id',$matchWhithoutProno->id,['class'=>'form-control','placeholder'=>'id'])}}
    </div>
</div>
{!! Form::close() !!}
</div>
{{$matchsWhithoutProno->links()}}