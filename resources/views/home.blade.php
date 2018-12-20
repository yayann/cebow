@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Places you're watching</div>

                    <div class="card-body">

                        <div class="pb-3">
                            @forelse($subscriptions as $subscription)
                                @include('home.watched_place')
                            @empty
                                No watched places yet
                            @endforelse

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mt-5">
                <div class="card">
                    <div class="card-header">Watch for a new place</div>

                    <div class="card-body">
                        <div class="pb-3">

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
