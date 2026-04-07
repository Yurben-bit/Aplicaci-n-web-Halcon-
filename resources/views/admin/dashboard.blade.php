@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Dashboard de Administrador</h1>
    <p>Bienvenido, {{ auth()->user()->name }}.</p>
</div>
@endsection
