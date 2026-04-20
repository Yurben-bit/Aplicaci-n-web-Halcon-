@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">Crear Nuevo Artículo - Proyecto Halcón</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('articulos.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre del Artículo</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ej. Motor de arranque" required>
                        </div>

                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción Detallada</label>
                            <textarea name="descripcion" id="descripcion" class="form-control" rows="4" placeholder="Escribe aquí los detalles..." required></textarea>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success">Guardar Registro</button>
                            <a href="{{ route('articulos.index') }}" class="btn btn-outline-secondary">Volver al Listado</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection