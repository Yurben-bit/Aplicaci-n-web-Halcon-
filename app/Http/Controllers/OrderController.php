<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Importante para las fotos

class OrderController extends Controller
{
    private function buildDescription(?string $invoiceNumber, ?string $customerName): string
    {
        $parts = array_filter([
            trim((string) $invoiceNumber),
            trim((string) $customerName),
        ]);

        return $parts ? implode(' - ', $parts) : 'Orden';
    }

    private function normalizeStatus(?string $status): string
    {
        $value = strtolower(trim((string) $status));

        return match ($value) {
            'in process', 'in_process', 'en proceso' => 'en_proceso',
            'in route', 'in_route', 'en ruta' => 'en_ruta',
            'delivered', 'entregado' => 'entregado',
            default => 'pendiente',
        };
    }

    /**
     * Requisito: Listado general de último a primero.
     */
    public function index()
    {
        // latest() ordena automáticamente por fecha de creación (descendente)
        $orders = Order::latest()->paginate(10); 
        return response()->json($orders);
    }

    public function show(Order $order)
    {
        return response()->json(['data' => $order]);
    }

    /**
     * Requisito: Creación de orden.
     */
    public function store(Request $request)
    {
        $request->validate([
            'invoiceNumber' => 'required|string',
            'customerName' => 'required|string',
            'customerNumber' => 'required|string',
            'fiscalData' => 'required|string',
            'date' => 'required',
            'deliveryAddress' => 'required|string',
            'notes' => 'nullable|string',
            'status' => 'nullable|string',
            'items' => 'nullable|array',
            'totalAmount' => 'nullable|numeric',
            'deleted' => 'nullable|boolean',
            'loadedUnitPhoto' => 'nullable|string',
            'deliveryEvidencePhoto' => 'nullable|string',
            'missingItems' => 'nullable|array',
        ]);

        $order = Order::create([
            'description' => $this->buildDescription($request->invoiceNumber, $request->customerName),
            'invoice_number' => $request->invoiceNumber,
            'customer_name' => $request->customerName,
            'customer_number' => $request->customerNumber,
            'fiscal_data' => $request->fiscalData,
            'order_date' => $request->date,
            'delivery_address' => $request->deliveryAddress,
            'notes' => $request->notes,
            'status' => $this->normalizeStatus($request->status),
            'items' => $request->items,
            'total_amount' => $request->totalAmount,
            'deleted' => $request->boolean('deleted', false),
            'loaded_unit_photo' => $request->loadedUnitPhoto,
            'delivery_evidence_photo' => $request->deliveryEvidencePhoto,
            'missing_items' => $request->missingItems,
        ]);

        return response()->json(['data' => $order], 201);
    }

    /**
     * Requisito: Actualización de estado y evidencia fotográfica.
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'invoiceNumber' => 'sometimes|string',
            'customerName' => 'sometimes|string',
            'customerNumber' => 'sometimes|string',
            'fiscalData' => 'sometimes|string',
            'date' => 'sometimes',
            'deliveryAddress' => 'sometimes|string',
            'notes' => 'sometimes|nullable|string',
            'status' => 'sometimes|string',
            'items' => 'sometimes|array',
            'totalAmount' => 'sometimes|numeric',
            'deleted' => 'sometimes|boolean',
            'loadedUnitPhoto' => 'sometimes|nullable|string',
            'deliveryEvidencePhoto' => 'sometimes|nullable|string',
            'loadedPhotoTimestamp' => 'sometimes|nullable|string',
            'deliveredPhotoTimestamp' => 'sometimes|nullable|string',
            'deliveryNotes' => 'sometimes|nullable|string',
            'missingItems' => 'sometimes|nullable|array',
        ]);

        if ($request->filled('invoiceNumber')) {
            $order->invoice_number = $request->invoiceNumber;
        }

        if ($request->filled('customerName')) {
            $order->customer_name = $request->customerName;
        }

        if ($request->filled('customerNumber')) {
            $order->customer_number = $request->customerNumber;
        }

        if ($request->filled('fiscalData')) {
            $order->fiscal_data = $request->fiscalData;
        }

        if ($request->filled('date')) {
            $order->order_date = $request->date;
        }

        if ($request->filled('deliveryAddress')) {
            $order->delivery_address = $request->deliveryAddress;
        }

        if ($request->filled('invoiceNumber') || $request->filled('customerName')) {
            $order->description = $this->buildDescription(
                $request->filled('invoiceNumber') ? $request->invoiceNumber : $order->invoice_number,
                $request->filled('customerName') ? $request->customerName : $order->customer_name,
            );
        }

        if ($request->has('notes')) {
            $order->notes = $request->notes;
        }

        if ($request->has('status')) {
            $order->status = $this->normalizeStatus($request->status);
        }

        if ($request->has('items')) {
            $order->items = $request->items;
        }

        if ($request->has('totalAmount')) {
            $order->total_amount = $request->totalAmount;
        }

        if ($request->has('deleted')) {
            $order->deleted = $request->boolean('deleted');
        }

        if ($request->has('loadedUnitPhoto')) {
            $order->loaded_unit_photo = $request->loadedUnitPhoto;
        }

        if ($request->has('deliveryEvidencePhoto')) {
            $order->delivery_evidence_photo = $request->deliveryEvidencePhoto;
        }

        if ($request->has('loadedPhotoTimestamp')) {
            $order->loaded_photo_timestamp = $request->loadedPhotoTimestamp;
        }

        if ($request->has('deliveredPhotoTimestamp')) {
            $order->delivered_photo_timestamp = $request->deliveredPhotoTimestamp;
        }

        if ($request->has('deliveryNotes')) {
            $order->delivery_notes = $request->deliveryNotes;
        }

        if ($request->has('missingItems')) {
            $order->missing_items = $request->missingItems;
        }

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

        return response()->json(['data' => $order]);
    }
    
    /**
     * Opcional: Eliminar orden.
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return response()->json(['message' => 'Order deleted successfully'], 200);
    }
}