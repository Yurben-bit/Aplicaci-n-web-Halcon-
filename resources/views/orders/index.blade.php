@extends('layouts.app') {{-- Esto hace que use el diseño de tu Dashboard --}}

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <strong>Listado de Órdenes</strong> (De última a primera)
        </div>
        <div class="card-body">
            @foreach($orders as $order)
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Orden #{{ $order->id }}</h5>
                        <p class="card-text">{{ $order->description }}</p>
                        <p><strong>Estado actual:</strong> 
                            <span class="badge {{ $order->status == 'delivered' ? 'bg-success' : 'bg-warning' }}">
                                {{ $order->status }}
                            </span>
                        </p>

                        <form action="{{ route('orders.update', $order->id) }}" method="POST" enctype="multipart/form-data" class="row g-3">
                            @csrf
                            @method('PUT')
                            
                            <div class="col-auto">
                                <select name="status" class="form-select">
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="in_route" {{ $order->status == 'in_route' ? 'selected' : '' }}>En Ruta</option>
                                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Entregado</option>
                                </select>
                            </div>

                            <div class="col-auto">
                                <input type="file" name="evidence" class="form-control" accept="image/*" capture="environment">
                            </div>

                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary">Actualizar Estado</button>
                            </div>
                        </form>

                        @if($order->evidence_path)
                            <div class="mt-3">
                                <strong>Evidencia:</strong><br>
                                <img src="{{ asset('storage/' . $order->evidence_path) }}" class="img-thumbnail" width="200">
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection