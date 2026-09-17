@extends('layouts.publico')

@section('title', 'Registrar Empresa - SuperFast')

@section('content')
    @include('auth.stitch-auth-content', [
        'defaultMode' => 'register',
        'defaultRole' => 'merchant'
    ])
@endsection
