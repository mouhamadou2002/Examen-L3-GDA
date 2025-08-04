<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $orders = Order::with('user')->orderByDesc('created_at')->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['orderItems.product', 'user'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = \App\Models\Order::findOrFail($id);
        $order->status = $request->input('status');
        $order->save();
        // Notification au client
        $order->user->notify(new \App\Notifications\OrderStatusUpdated($order));
        return redirect()->back()->with('success', 'Statut de la commande mis à jour.');
    }

    public function updatePayment(Request $request, $id)
    {
        $order = \App\Models\Order::findOrFail($id);
        $oldStatus = $order->payment_status;
        $order->payment_status = $request->input('payment_status');
        $order->save();
        // Notification au client si paiement confirmé
        if ($oldStatus !== 'paye' && $order->payment_status === 'paye') {
            $order->user->notify(new \App\Notifications\OrderPaymentConfirmed($order));
        }
        return redirect()->back()->with('success', 'Statut de paiement mis à jour.');
    }
} 