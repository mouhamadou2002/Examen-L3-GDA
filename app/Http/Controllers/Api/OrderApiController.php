<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderApiController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $orders = $user->orders()->with(['user', 'orderItems.product'])->get();
        return response()->json($orders);
    }

    public function show($id)
    {
        $user = auth()->user();
        $order = $user->orders()->with(['user', 'orderItems.product'])->find($id);
        if (!$order) {
            return response()->json(['error' => 'Commande non trouvée'], 404);
        }
        return response()->json($order);
    }
} 