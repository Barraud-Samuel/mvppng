@if($matchWithProno->status == 'FINISHED')
    <div class="card text-center mt-3">
        <div class="card-title">
            <p class="pt-3">jour de la competition : {{$matchWithProno->matchday}}
                <span class="{{($matchWithProno->status == 'INCOMMING')?'badge-warning badge ' : (($matchWithProno->status == 'RUNNING')?'badge-success badge ':'badge badge-primary                                               ')}}">
                        {{($matchWithProno->status == 'INCOMMING')?'à venir' : (($matchWithProno->status == 'RUNNING')?'en cours':'terminé')}}
            </span>
            </p>
        </div>
        <div class="row">
            <div class="col-5">
                <p>{{$matchWithProno->homeTeamName}}</p>
                <p>{{$matchWithProno->result_goalsHomeTeam}}</p>
            </div>
            <div class="col-2">
                <p>Match terminé</p>
                @if($Prono->correct_result == true)
                    <p>vous avez bien pronostiqué 😃</p>
                @elseif($Prono->correct_result == false)
                    <p>Mauvais prono, vous ferez mieux la prochaine fois 😔</p>
                @endif
            </div>
            <div class="col-5">
                <p>{{$matchWithProno->awayTeamName}}</p>
                <p>{{$matchWithProno->result_goalsAwayTeam}}</p>
            </div>
        </div>
    </div>
@else
    <div class="card text-center mt-3">
        <div class="card-title">
            <p class="pt-3">jour de la competition : {{$matchWithProno->matchday}}
                <span class="{{($matchWithProno->status == 'INCOMMING')?'badge-warning badge ' : (($matchWithProno->status == 'RUNNING')?'badge-success badge ':'badge badge-primary                                               ')}}">
                        {{($matchWithProno->status == 'INCOMMING')?'à venir' : (($matchWithProno->status == 'RUNNING')?'en cours':'terminé')}}
            </span>
            </p>
        </div>
        {!! Form::open(['action' => ['MatchsController@update', $Prono->id],'method'=>'POST','class'=>'row']) !!}
        <div class="col-5">
            <p>{{$matchWithProno->homeTeamName}}</p>
            <p>{{$matchWithProno->result_goalsHomeTeam}}</p>
            <div class="form-group px-5">
                {{Form::label('homeTeam_prono','score')}}
                {{Form::number('homeTeam_prono',$Prono->homeTeam_prono,['class'=>'form-control text-center','placeholder'=>'score'])}}
            </div>
        </div>

        <div class="col-2">
            <p></p>
            <p>vs</p>
            {{Form::submit('modifier',['class'=>'btn btn-primary my-2'])}}
        </div>

        <div class="col-5">
            <p>{{$matchWithProno->awayTeamName}}</p>
            <p>{{$matchWithProno->result_goalsAwayTeam}}</p>
            <div class="form-group px-5">
                {{Form::label('homeTeam_prono','score')}}
                {{Form::number('awayTeam_prono',$Prono->awayTeam_prono,['class'=>'form-control text-center','placeholder'=>'score'])}}
                {{Form::hidden('match_id',$matchWithProno->id,['class'=>'form-control','placeholder'=>'id'])}}
            </div>
        </div>
        {!! Form::hidden('_method','PUT') !!}
        {!! Form::close() !!}
    </div>
@endif
{{$matchsWithProno->links()}}