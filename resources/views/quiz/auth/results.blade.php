@extends('layouts.dashboard')

@section('content')

    @include('layouts.headers.cards')
        
    <div class="container-fluid mt--7">
        <all-results></all-results>

        @include('layouts.footers.auth')
    </div>

@endsection
