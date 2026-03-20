@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header bg-white fw-bold">
                <span><svg class="icon me-2"><use xlink:href="{{ asset('assets/icons/sprites/free.svg#cil-pencil') }}"></use></svg> Editar Material</span>
            </div>
            <div class="card-body">
                <form action="{{ route('materials.update', $material) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="clave_material" class="form-label">Clave Material</label>
                        <input type="number" class="form-control @error('clave_material') is-invalid @enderror" id="clave_material" name="clave_material" value="{{ old('clave_material', $material->clave_material) }}" required>
                        @error('clave_material')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="descripcion_material" class="form-label">Descripción</label>
                        <input type="text" class="form-control @error('descripcion_material') is-invalid @enderror" id="descripcion_material" name="descripcion_material" value="{{ old('descripcion_material', $material->descripcion_material) }}" required>
                        @error('descripcion_material')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="precio_unitario" class="form-label">Precio Unitario</label>
                            <input type="number" class="form-control @error('precio_unitario') is-invalid @enderror" id="precio_unitario" name="precio_unitario" value="{{ old('precio_unitario', $material->precio_unitario) }}" min="0" required>
                            @error('precio_unitario')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="cantidad_material" class="form-label">Cantidad</label>
                            <input type="number" class="form-control @error('cantidad_material') is-invalid @enderror" id="cantidad_material" name="cantidad_material" value="{{ old('cantidad_material', $material->cantidad_material) }}" min="0" required>
                            @error('cantidad_material')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('materials.index') }}" class="btn btn-secondary me-2">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Actualizar Material</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection