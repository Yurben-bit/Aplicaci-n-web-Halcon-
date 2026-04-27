@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Editar Artículo: {{ $articulo->nombre }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('articulos.update', $articulo->id) }}" method="POST">
                        @csrf
                        @method('PUT') 

                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $articulo->nombre }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea name="descripcion" id="descripcion" class="form-control" rows="4" required>{{ $articulo->descripcion }}</textarea>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Actualizar Cambios</button>
                            <a href="{{ route('articulos.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection