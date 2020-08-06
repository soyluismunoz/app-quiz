@extends('layouts.app')

@section('content')
    <div class="flex-center position-ref half-height">
        <div class="content">
            <div class="title mb-2">
                {{ __('Certificaciones')}}
            </div>

            <div class="links">
                <p class="text-lead">
                    <b>{{   __('Bienvenido')}}</b> {{ __('al sistemas de Certificaciones') }}
                </p>
                <a href=" {{ route('home') }}" class="btn btn-success py-2 text-white" > 
                    {{ __('Iniciar certificacion') }} 
                </a>
            </div>
        </div>
    </div>
@endsection
