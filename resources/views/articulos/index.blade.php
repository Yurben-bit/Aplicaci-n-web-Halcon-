@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h3 class="mb-0">Panel de Control - Proyecto Halcón</h3>
            <a href="{{ route('articulos.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Agregar Nuevo Articulo
            </a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <table class="table table-striped table-hover mt-3">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nombre del Artículo</th>
                        <th>Descripción</th>
                        <th class="text-center">Operaciones CRUD</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($articulos as $articulo)
                        <tr>
                            <td>{{ $articulo->id }}</td>
                            <td><strong>{{ $articulo->nombre }}</strong></td>
                            <td>{{ $articulo->descripcion }}</td>
                            <td class="text-center">
                                <a href="{{ route('articulos.edit', $articulo->id) }}" class="btn btn-warning btn-sm">
                                    Editar
                                </a>

                                <form action="{{ route('articulos.destroy', $articulo->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que quieres eliminar este registro?')">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Aún no hay datos. Haz clic en "Agregar Nuevo" para empezar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection