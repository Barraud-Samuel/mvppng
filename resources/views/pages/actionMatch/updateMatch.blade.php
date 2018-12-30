{{--si le match est fini on affiche le resultat du prono --}}
@if($matchWithProno->status == 'FINISHED')
    <div class="card text-center mt-4">
        <div class="card-title {{($Prono->correct_result == true)?'bg-success' : (($Prono->correct_result == false)?'bg-danger':'bg-dark')}}">
            <p class="text-white pt-3">jour de la competition : {{$matchWithProno->matchday}}
                <span class="{{($matchWithProno->status == 'INCOMMING')?'badge-warning badge ' : (($matchWithProno->status == 'RUNNING')?'badge-success badge ':'badge badge-primary                                               ')}}">
                        {{($matchWithProno->status == 'INCOMMING')?'à venir' : (($matchWithProno->status == 'RUNNING')?'en cours':'terminé')}}
            </span>
            </p>
        </div>
        <div class="row">
            <div class="col-5">
                <p>{{$matchWithProno->homeTeamName}}</p>
                <p class="align-middle">{{$matchWithProno->result_goalsHomeTeam}}</p>
            </div>
            <div class="col-2">
                <div class="card text-center mt-3 mb-4">
                    <div class="card-title {{($Prono->correct_result == true)?'bg-success' : (($Prono->correct_result == false)?'bg-danger':'bg-dark')}}">
                        @if($Prono->correct_result == true)
                            <p class="text-white mb-0 py-2">😃</p>
                        @elseif($Prono->correct_result == false)
                            <p class="text-white mb-0 py-2">😔</p>
                        @endif
                    </div>
                    <div class="card-body">
                        <h2 class="font-weight-bold {{($Prono->correct_result == true)?'text-success' : (($Prono->correct_result == false)?'text-danger':'text-dark')}}">{{$Prono->homeTeam_prono}} - {{$Prono->awayTeam_prono}}</h2>
                    </div>
                </div>
            </div>
            <div class="col-5">
                <p>{{$matchWithProno->awayTeamName}}</p>
                <p>{{$matchWithProno->result_goalsAwayTeam}}</p>
            </div>
        </div>
    </div>
{{--sinon on affiche le formulaire pour modifier son prono --}}
@else
    <div class="card text-center mt-4">
        <div class="card-title bg-dark">
            <p class="text-white pt-3">jour de la competition : {{$matchWithProno->matchday}}
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