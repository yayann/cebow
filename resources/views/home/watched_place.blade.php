<b>{{$subscription->locality}}</b>
@if($subscription->street)
    : {{$subscription->street}}
@endif

@if($subscription->hasPlannedOutages())
    <ul>
        @foreach($subscription->planned_outages as $outage)
            <li>
                Planned: {{$outage->outage_from->format('l d/m/Y')}}
                from {{$outage->outage_from->format('H:i')}} to
                {{$outage->outage_to->format('H:i')}}
                <a href="#" class="btn btn-outline-info btn-sm" onclick="$('#more-info-{{$outage->id}}').toggle()">
                    <span class="fa fa-info"></span>
                </a>
                <br>
                <p id="more-info-{{$outage->id}}" style="display: none;" class="text-muted">{{$outage->roads}}</p>
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
                <a href="#" class="btn btn-outline-info btn-sm" onclick="$('#more-info-{{$outage->id}}').toggle()">
                    <span class="fa fa-info"></span>
                </a>
                <br>
                <p id="more-info-{{$outage->id}}" style="display: none;" class="text-muted">{{$outage->roads}}</p>
            </li>
        @endforeach
    </ul>
@endif

{{ bs()->openForm('delete', route('subscriber.destroy', $subscription->id)) }}
{{ bs()->formGroup()
        ->control(bs()->submit('Delete', 'danger')->sizeSmall()
        ->child('<span class="fa fa-trash ml-2"></span>'))

        }}
{{ bs()->closeForm() }}