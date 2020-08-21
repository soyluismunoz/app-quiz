@extends('layouts.dashboard')

@section('content')

    @include('layouts.headers.cards')
        
    <div class="container-fluid mt--7">
        <all-quizes></all-quizes>

        @include('layouts.footers.auth')
    </div>

@endsection
