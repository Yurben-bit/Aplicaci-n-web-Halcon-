@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header bg-white fw-bold d-flex justify-content-between align-items-center">
                <span>
                    <svg class="icon me-2">
                        <use xlink:href="{{ asset('assets/icons/sprites/free.svg#cil-layers') }}"></use>
                    </svg>
                    Gestión de Materiales
                </span>
                <a href="{{ route('materials.create') }}" class="btn btn-sm btn-primary">Nuevo Material</a>
            </div>

            <div class="card-body">

                {{-- Mensajes de éxito o error --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-coreui-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-coreui-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Clave</th>
                                <th>Descripción</th>
                                <th>Precio Unitario</th>
                                <th>Cantidad</th>
                                <th>Fecha Registro</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($materials as $material)
                                <tr>
                                    <td>{{ $material->id }}</td>
                                    <td>{{ $material->clave_material }}</td>
                                    <td>{{ $material->descripcion_material }}</td>
                                    <td>${{ number_format($material->precio_unitario, 2) }}</td>
                                    <td>{{ $material->cantidad_material }}</td>
                                    <td>{{ $material->created_at->format('d/m/Y') }}</td>

                                    <td>
                                        <div class="d-flex gap-2">

                                            {{-- Botón Editar --}}
                                            <a href="{{ route('materials.edit', $material) }}" class="btn btn-sm btn-info text-white">
                                                <svg class="icon me-1">
                                                    <use xlink:href="{{ asset('assets/icons/sprites/free.svg#cil-pencil') }}"></use>
                                                </svg>
                                                Editar
                                            </a>

                                            {{-- Botón Eliminar --}}
                                            <form action="{{ route('materials.destroy', $material) }}" method="POST" class="d-inline"
                                                onsubmit="return confirm('¿Estás seguro de que deseas eliminar este material?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger text-white">
                                                    <svg class="icon me-1">
                                                        <use xlink:href="{{ asset('assets/icons/sprites/free.svg#cil-trash') }}"></use>
                                                    </svg>
                                                    Eliminar
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No hay materiales registrados.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Paginación --}}
                <div class="d-flex justify-content-center mt-3">
                    {{ $materials->links() }}
                </div>

            </div>
        </div>
    </div>
</div>
@endsection