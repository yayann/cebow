@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">All Planned Outages: {{count($outages)}}</div>

                    <div class="card-body">
                        <ul>
                        @foreach($outages as $outage)
                            <li>
                                <b>{{$outage->locality}}</b> : {{$outage->outage_from->format('l d/m/Y')}} from {{$outage->outage_from->format('H:i')}} to
                                {{$outage->outage_to->format('H:i')}}
                                <a href="#" class="btn btn-outline-info btn-sm" onclick="$('#more-info-{{$outage->id}}').toggle()">
                                    <span class="fa fa-info"></span>
                                </a>
                                <br>
                                <p id="more-info-{{$outage->id}}" style="display: none;" class="text-muted">{{$outage->roads}}</p>
                            </li>
                        @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
