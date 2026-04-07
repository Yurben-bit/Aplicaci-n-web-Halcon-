@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">

        <div class="card mb-4">
            <div class="card-header bg-white fw-bold d-flex justify-content-between align-items-center">
                <span>
                    <svg class="icon me-2">
                        <use xlink:href="{{ asset('assets/icons/sprites/free.svg#cil-shield-alt') }}"></use>
                    </svg>
                    Gestión de Roles
                </span>
                <a href="{{ route('roles.create') }}" class="btn btn-sm btn-primary">Nuevo Rol</a>
            </div>

            <div class="card-body">

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-coreui-dismiss="alert"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Nombre del Rol</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($roles as $role)
                                <tr>
                                    <td>{{ $role->id }}</td>
                                    <td>{{ $role->nombreRol }}</td>

                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('roles.edit', $role) }}" class="btn btn-sm btn-info text-white">
                                                <svg class="icon me-1">
                                                    <use xlink:href="{{ asset('assets/icons/sprites/free.svg#cil-pencil') }}"></use>
                                                </svg>
                                                Editar
                                            </a>

                                            <form action="{{ route('roles.destroy', $role) }}" method="POST" onsubmit="return confirm('¿Eliminar este rol?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger text-white">
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
                                    <td colspan="3" class="text-center">No hay roles registrados.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-3">
                    {{ $roles->links() }}
                </div>

            </div>
        </div>

    </div>
</div>
@endsection
