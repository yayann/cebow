@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">

                        <div class="pb-3">


                            <h3>Places you're watching</h3>
                            <ul>
                                @forelse($subscriptions as $subscription)
                                    <li>
                                        @include('home.watched_place')
                                    </li>
                                @empty
                                    No watched places yet
                                @endforelse
                            </ul>

                        </div>
                        <div class="pb-3">


                            <h3>Watch for a new place</h3>

                            {{ bs()->openForm('post', route('subscriber.store')) }}

                            {{  bs()->formGroup()
                                    ->control(bs()->inputGroup(bs()->text('locality')))
                                    ->label('Locality', false)
                                    ->helpText("E.g 'Camp Levieux', 'Sebastopol', …")
                                    ->showAsRow() }}

                            {{  bs()->formGroup()
                                    ->control(bs()->inputGroup(bs()->text('street')))
                                    ->label('Street', false)
                                    ->helpText("If provided, we will only warn you if your street name matches")
                                    ->showAsRow() }}

                            {{   bs()->submit('Add') }}

                            {{ bs()->closeForm() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
