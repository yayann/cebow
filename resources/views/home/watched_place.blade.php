<?php
use App\Support\Html\LocalityStatChart;
?>

<div class="row">
    <div class="col-md-12">
        <b>{{$subscription->locality}}</b>
        @if($subscription->street)
            : {{$subscription->street}}
        @endif
    </div>

    <div class="col-md-2">
        {{ bs()->openForm('delete', route('subscriber.destroy', $subscription->id)) }}
        {{ bs()->formGroup()
                ->control(bs()->submit('Delete', 'danger')->sizeSmall()
                ->child('<span class="fa fa-trash ml-2"></span>'))

                }}
        {{ bs()->closeForm() }}
    </div>

    <div class="col-md-4">

        @if($subscription->hasPlannedOutages())
            <ul>
                @foreach($subscription->planned_outages as $outage)
                    <li>
                        {{$outage->locality}}<br>
                        Planned: {{$outage->outage_from->format('l d/m/Y')}}
                        from {{$outage->outage_from->format('H:i')}} to
                        {{$outage->outage_to->format('H:i')}}
                        <a href="#" class="btn btn-outline-info btn-sm"
                           onclick="$('#more-info-{{$outage->id}}').toggle()">
                            <span class="fa fa-info"></span>
                        </a>
                        <br>
                        <p id="more-info-{{$outage->id}}" style="display: none;"
                           class="text-muted">{{$outage->roads}}</p>
                    </li>
                @endforeach
            </ul>
        @endif

        @if($subscription->hasCurrentOutages())
            <ul>
                @foreach($subscription->current_outages as $outage)
                    <li>
                        <b>Currently</b>:
                        from {{$outage->outage_from->format('H:i')}} to
                        {{$outage->outage_to->format('H:i')}}
                        <a href="#" class="btn btn-outline-info btn-sm"
                           onclick="$('#more-info-{{$outage->id}}').toggle()">
                            <span class="fa fa-info"></span>
                        </a>
                        <br>
                        <p id="more-info-{{$outage->id}}" style="display: none;"
                           class="text-muted">{{$outage->roads}}</p>
                    </li>
                @endforeach
            </ul>
        @endif

        @if(! ($subscription->hasPlannedOutages() || $subscription->hasCurrentOutages()))
            <p class="text-success">Nothing planned</p>
        @endif
    </div>

    <div class="col-md-6">

        <?php $chart = (new LocalityStatChart)->make($subscription->locality); ?>

        @if($chart !== false)
            <p class="text-center">Last outages by week</p>
            {!! $chart->height(140)->container() !!}
            {!! $chart->script() !!}
        @else
                <p class="text-center">No data</p>
        @endif

    </div>

</div>

@if(!$loop->last)
    <hr>
@endif