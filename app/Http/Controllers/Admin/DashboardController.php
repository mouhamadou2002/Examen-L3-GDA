<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $totalSales = Order::where('status', '!=', 'annulee')->sum('total');
        $ordersCount = Order::count();
        $productsCount = Product::count();
        $clientsCount = User::where('role', 'client')->count();
        $topProducts = Product::withCount(['orderItems as total_vendus' => function($q) {
            $q->select(\DB::raw('SUM(quantity)'));
        }])->orderByDesc('total_vendus')->take(5)->get();

        return view('admin.dashboard', compact('totalSales', 'ordersCount', 'productsCount', 'clientsCount', 'topProducts'));
    }

    public function markNotificationRead($id)
    {
        $notification = auth()->user()->notifications()->where('id', $id)->first();
        if ($notification) {
            $notification->markAsRead();
        }
        return redirect()->route('admin.dashboard');
    }
} 