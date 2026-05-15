<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'ordered', 'pendiente' => 'Ordered',
            'in process', 'in_process', 'en proceso' => 'In Process',
            'in route', 'in_route', 'en ruta' => 'In Route',
            'delivered', 'entregado' => 'Delivered',
            default => 'Ordered',
        };
    }

    public function index()
    {
        $orders = Order::latest()->paginate(10);
        return response()->json(['data' => $orders]);
    }

    public function show(Order $order)
    {
        return response()->json(['data' => $order]);
    }

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
        ]);

        return response()->json(['data' => $order], 201);
    }

    public function update(Request $request, Order $order)
    {
        // VALIDACIÓN
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
            'loadedPhotoTimestamp' => 'sometimes|string',
            'deliveredPhotoTimestamp' => 'sometimes|string',
            'deliveryNotes' => 'sometimes|string',
            'missingItems' => 'sometimes|array',
            'loadedUnitPhoto' => 'sometimes|file|image|max:20480',
            'deliveryEvidencePhoto' => 'sometimes|file|image|max:20480',
        ]);

        // CAMPOS NORMALES
        foreach ([
            'invoiceNumber' => 'invoice_number',
            'customerName' => 'customer_name',
            'customerNumber' => 'customer_number',
            'fiscalData' => 'fiscal_data',
            'date' => 'order_date',
            'deliveryAddress' => 'delivery_address',
            'notes' => 'notes',
            'items' => 'items',
            'totalAmount' => 'total_amount',
            'deleted' => 'deleted',
            'deliveryNotes' => 'delivery_notes',
            'missingItems' => 'missing_items',
        ] as $input => $field) {
            if ($request->has($input)) {
                $order->$field = $request->$input;
            }
        }

        // STATUS
        if ($request->has('status')) {
            $order->status = $this->normalizeStatus($request->status);
        }

        // DESCRIPCIÓN
        if ($request->filled('invoiceNumber') || $request->filled('customerName')) {
            $order->description = $this->buildDescription(
                $request->invoiceNumber ?? $order->invoice_number,
                $request->customerName ?? $order->customer_name
            );
        }

        // FOTO DE UNIDAD CARGADA
        if ($request->hasFile('loadedUnitPhoto')) {
            if ($order->loaded_unit_photo) {
                Storage::disk('public')->delete($order->loaded_unit_photo);
            }

            $path = $request->file('loadedUnitPhoto')->store('loaded_units', 'public');
            $order->loaded_unit_photo = $path;

            if ($request->filled('loadedPhotoTimestamp')) {
                $order->loaded_photo_timestamp = $request->loadedPhotoTimestamp;
            }
        }

        // FOTO DE ENTREGA
        if ($request->hasFile('deliveryEvidencePhoto')) {
            if ($order->delivery_evidence_photo) {
                Storage::disk('public')->delete($order->delivery_evidence_photo);
            }

            $path = $request->file('deliveryEvidencePhoto')->store('deliveries', 'public');
            $order->delivery_evidence_photo = $path;

            if ($request->filled('deliveredPhotoTimestamp')) {
                $order->delivered_photo_timestamp = $request->deliveredPhotoTimestamp;
            }

            // Cambiar estado automáticamente
            $order->status = 'Delivered';
        }

        $order->save();

        return response()->json(['data' => $order]);
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return response()->json(['message' => 'Order deleted successfully'], 200);
    }
}