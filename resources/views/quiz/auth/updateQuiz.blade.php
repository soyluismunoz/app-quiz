@extends('layouts.dashboard', ['title' => __('Crear Quiz')])

@section('content')

    @include('users.partials.header', ['title' => __('Nueva certificación')])   
        
    <div class="container-fluid mt--7">
        <update-quiz></update-quiz>

        @include('layouts.footers.auth')
    </div>

@endsection