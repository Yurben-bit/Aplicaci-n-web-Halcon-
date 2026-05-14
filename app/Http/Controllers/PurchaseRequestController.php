<?php

namespace App\Http\Controllers;

use App\Models\PurchaseRequest;
use Illuminate\Http\Request;

class PurchaseRequestController extends Controller
{
    public function index()
    {
        return response()->json(
            PurchaseRequest::with(['material', 'provider'])->latest()->paginate(10)
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'materialId' => 'required|exists:materials,id',
            'providerId' => 'required|exists:providers,id',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
            'status' => 'nullable|string',
        ]);

        $purchaseRequest = PurchaseRequest::create([
            'material_id' => $request->materialId,
            'provider_id' => $request->providerId,
            'quantity' => $request->quantity,
            'notes' => $request->notes,
            'status' => strtolower($request->input('status', 'pending')),
        ]);

        return response()->json(['data' => $purchaseRequest->load(['material', 'provider'])], 201);
    }

    public function show(PurchaseRequest $purchaseRequest)
    {
        return response()->json(['data' => $purchaseRequest->load(['material', 'provider'])]);
    }

    public function update(Request $request, PurchaseRequest $purchaseRequest)
    {
        $request->validate([
            'materialId' => 'sometimes|exists:materials,id',
            'providerId' => 'sometimes|exists:providers,id',
            'quantity' => 'sometimes|integer|min:1',
            'notes' => 'sometimes|nullable|string',
            'status' => 'sometimes|string',
        ]);

        if ($request->has('materialId')) {
            $purchaseRequest->material_id = $request->materialId;
        }

        if ($request->has('providerId')) {
            $purchaseRequest->provider_id = $request->providerId;
        }

        if ($request->has('quantity')) {
            $purchaseRequest->quantity = $request->quantity;
        }

        if ($request->has('notes')) {
            $purchaseRequest->notes = $request->notes;
        }

        if ($request->has('status')) {
            $purchaseRequest->status = strtolower($request->status);
        }

        $purchaseRequest->save();

        return response()->json(['data' => $purchaseRequest->load(['material', 'provider'])]);
    }

    public function destroy(PurchaseRequest $purchaseRequest)
    {
        $purchaseRequest->delete();

        return response()->json(['message' => 'Purchase request deleted successfully']);
    }

    public function latestByMaterial($materialId)
    {
        try {
            $pr = PurchaseRequest::where('material_id', $materialId)
                ->where('status', 'purchased') // en minúsculas, para evitar problemas de comparación
                ->orderBy('created_at', 'desc')
                ->first();

            return response()->json($pr, 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}