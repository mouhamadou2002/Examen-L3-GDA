<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    // Affichage du catalogue produits
    public function index(Request $request)
    {
        $categories = Category::all();
        $query = Product::query();
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        if ($request->filled('search')) {
            $query->where('name', 'like', '%'.$request->search.'%');
        }
        $products = $query->paginate(12);
        return view('shop.index', compact('products', 'categories'));
    }

    // Fiche produit
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('shop.show', compact('product'));
    }

    // Ajouter au panier
    public function addToCart(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);
        $quantityToAdd = $request->input('quantity', 1);
        $currentQty = isset($cart[$id]) ? $cart[$id]['quantity'] : 0;
        $newQty = $currentQty + $quantityToAdd;
        if ($newQty > $product->stock) {
            return redirect()->route('shop.cart')->with('error', 'Stock insuffisant pour ce produit. Stock disponible : ' . $product->stock);
        }
        if(isset($cart[$id])) {
            $cart[$id]['quantity'] = $newQty;
        } else {
            $cart[$id] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantityToAdd,
                'image' => $product->image
            ];
        }
        session(['cart' => $cart]);
        return redirect()->route('shop.cart')->with('success', 'Produit ajouté au panier.');
    }

    // Afficher le panier
    public function cart()
    {
        $cart = session('cart', []);
        return view('shop.cart', compact('cart'));
    }

    // Modifier la quantité dans le panier
    public function updateCart(Request $request, $id)
    {
        $cart = session()->get('cart', []);
        if(isset($cart[$id])) {
            $product = Product::findOrFail($id);
            $newQty = $request->input('quantity', 1);
            if ($newQty > $product->stock) {
                return redirect()->route('shop.cart')->with('error', 'Stock insuffisant pour ce produit. Stock disponible : ' . $product->stock);
            }
            $cart[$id]['quantity'] = $newQty;
            session(['cart' => $cart]);
        }
        return redirect()->route('shop.cart')->with('success', 'Panier mis à jour.');
    }

    // Supprimer un produit du panier
    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);
        if(isset($cart[$id])) {
            unset($cart[$id]);
            session(['cart' => $cart]);
        }
        return redirect()->route('shop.cart')->with('success', 'Produit retiré du panier.');
    }

    // Formulaire de validation de commande
    public function checkout()
    {
        $cart = session('cart', []);
        if(empty($cart)) {
            return redirect()->route('shop.cart')->with('error', 'Votre panier est vide.');
        }
        return view('shop.checkout', compact('cart'));
    }

    // Enregistrement de la commande
    public function placeOrder(Request $request)
    {
        $cart = session('cart', []);
        if(empty($cart)) {
            return redirect()->route('shop.cart')->with('error', 'Votre panier est vide.');
        }
        // Vérification du stock pour chaque produit
        foreach($cart as $item) {
            $product = Product::find($item['product_id']);
            if (!$product || $item['quantity'] > $product->stock) {
                return redirect()->route('shop.cart')->with('error', 'Stock insuffisant pour le produit : ' . ($product->name ?? 'Inconnu'));
            }
        }
        $validated = $request->validate([
            'delivery_address' => 'required|string|max:255',
            'payment_mode' => 'required|in:en_ligne,a_la_livraison',
        ]);
        $order = Order::create([
            'user_id' => Auth::id(),
            'total' => collect($cart)->sum(function($item) { return $item['price'] * $item['quantity']; }),
            'status' => 'en_attente',
            'payment_status' => 'non_paye',
            'payment_mode' => $validated['payment_mode'],
            'delivery_address' => $validated['delivery_address'],
        ]);
        foreach($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
            // Décrémenter le stock
            $product = Product::find($item['product_id']);
            $product->stock -= $item['quantity'];
            $product->save();
        }
        // Générer et stocker la facture PDF
        $pdf = \PDF::loadView('invoices.invoice_pdf', compact('order'));
        $filename = 'factures/facture_commande_' . $order->id . '.pdf';
        \Illuminate\Support\Facades\Storage::put('public/' . $filename, $pdf->output());
        // Notification email de confirmation de commande
        auth()->user()->notify(new \App\Notifications\OrderPlaced($order));

        // Notification à l'admin
        $admin = \App\Models\User::where('role', 'admin')->first();
        if ($admin) {
            $admin->notify(new \App\Notifications\OrderPlacedAdmin($order));
        }
        session()->forget('cart');
        return redirect()->route('shop.index')->with('success', 'Commande passée avec succès !');
    }

    // Historique des commandes du client
    public function myOrders()
    {
        $orders = \App\Models\Order::where('user_id', auth()->id())->orderByDesc('created_at')->get();
        return view('shop.my_orders', compact('orders'));
    }

    // Détail d'une commande du client
    public function orderDetail($id)
    {
        $order = \App\Models\Order::where('user_id', auth()->id())->where('id', $id)->firstOrFail();
        $items = $order->orderItems;
        return view('shop.order_detail', compact('order', 'items'));
    }

    public function markNotificationRead($id)
    {
        $notification = auth()->user()->notifications()->where('id', $id)->first();
        if ($notification) {
            $notification->markAsRead();
        }
        return redirect()->route('shop.myOrders');
    }
} 