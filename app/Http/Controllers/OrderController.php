<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Importante para las fotos

class OrderController extends Controller
{
    /**
     * Requisito: Listado general de último a primero.
     */
    public function index()
    {
        // latest() ordena automáticamente por fecha de creación (descendente)
        $orders = Order::latest()->get(); 
        return view('orders.index', compact('orders'));
    }

    /**
     * Requisito: Creación de orden.
     */
    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required',
        ]);

        Order::create($request->all());

        return redirect()->route('orders.index')->with('success', 'Orden creada.');
    }

    /**
     * Requisito: Actualización de estado y evidencia fotográfica.
     */
    public function update(Request $request, Order $order)
    {
        // 1. Actualizamos el estado (Pendiente, En Ruta, Entregado)
        $order->status = $request->status;

        // 2. Si el estado es 'in_route' o 'delivered', manejamos la foto
        if ($request->hasFile('evidence')) {
            // Borrar foto anterior si existe para no llenar el disco
            if ($order->evidence_path) {
                Storage::disk('public')->delete($order->evidence_path);
            }

            // Guardar la nueva foto en storage/app/public/evidences
            $path = $request->file('evidence')->store('evidences', 'public');
            $order->evidence_path = $path;
        }

        $order->save();

        return redirect()->back()->with('success', 'Estado actualizado correctamente.');
    }
    
    /**
     * Opcional: Eliminar orden.
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index');
    }
}