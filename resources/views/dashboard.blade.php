@extends('layouts.dashboard')

@section('content')

    @include('layouts.headers.cards')
        
    <div class="container-fluid mt--7">
        <main-tables>
            <template slot="results">
                <a href="{{ route('results') }}" class="btn btn-sm btn-primary">Ver todos</a>
            </template>
            <template slot="users">
                <a href="{{ route('user.index') }}" class="btn btn-sm btn-primary">Ver Todos</a>
            </template>
        <main-tables>

        @include('layouts.footers.auth')
    </div>

@endsection
