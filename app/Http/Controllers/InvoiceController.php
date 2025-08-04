<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use PDF;

class InvoiceController extends Controller
{
    public function download($orderId)
    {
        $order = Order::with(['orderItems.product', 'user'])->findOrFail($orderId);

        // Sécurité : Seul le client concerné ou un admin peut télécharger la facture
        if (auth()->user()->role !== 'admin' && $order->user_id !== auth()->id()) {
            abort(403, 'Accès interdit');
        }

        $pdf = PDF::loadView('invoices.invoice_pdf', compact('order'));
        $filename = 'facture_commande_' . $order->id . '.pdf';

        return $pdf->download($filename);
    }
} 