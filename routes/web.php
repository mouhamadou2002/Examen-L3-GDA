<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\Admin\DashboardController;



Route::get('/', [ShopController::class, 'index'])->name('shop.index');
Route::get('/produit/{id}', [ShopController::class, 'show'])->name('shop.show');

Route::middleware('auth')->group(function () {
    Route::post('/panier/ajouter/{id}', [ShopController::class, 'addToCart'])->name('shop.addToCart');
    Route::get('/panier', [ShopController::class, 'cart'])->name('shop.cart');
    Route::post('/panier/update/{id}', [ShopController::class, 'updateCart'])->name('shop.updateCart');
    Route::post('/panier/remove/{id}', [ShopController::class, 'removeFromCart'])->name('shop.removeFromCart');
    Route::get('/commande', [ShopController::class, 'checkout'])->name('shop.checkout');
    Route::post('/commande', [ShopController::class, 'placeOrder'])->name('shop.placeOrder');
    Route::post('/notifications/read/{id}', [\App\Http\Controllers\ShopController::class, 'markNotificationRead'])->name('shop.notifications.read');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/mes-commandes', [\App\Http\Controllers\ShopController::class, 'myOrders'])->name('shop.myOrders');
    Route::get('/mes-commandes/{id}', [\App\Http\Controllers\ShopController::class, 'orderDetail'])->name('shop.orderDetail');
});

Route::get('/facture/{order}', [InvoiceController::class, 'download'])->middleware('auth')->name('invoice.download');

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/produits', [\App\Http\Controllers\Admin\ProductController::class, 'index'])->name('products.index');
    Route::get('/produits/create', [\App\Http\Controllers\Admin\ProductController::class, 'create'])->name('products.create');
    Route::post('/produits', [\App\Http\Controllers\Admin\ProductController::class, 'store'])->name('products.store');
    Route::get('/produits/{product}/edit', [\App\Http\Controllers\Admin\ProductController::class, 'edit'])->name('products.edit');
    Route::put('/produits/{product}', [\App\Http\Controllers\Admin\ProductController::class, 'update'])->name('products.update');
    Route::delete('/produits/{product}', [\App\Http\Controllers\Admin\ProductController::class, 'destroy'])->name('products.destroy');
    Route::get('/categories', [\App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [\App\Http\Controllers\Admin\CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [\App\Http\Controllers\Admin\CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}/edit', [\App\Http\Controllers\Admin\CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [\App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [\App\Http\Controllers\Admin\CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::get('/commandes', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
    Route::get('/commandes/{order}', [\App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');
    Route::get('/utilisateurs', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
    Route::get('/utilisateurs/{user}/edit', [\App\Http\Controllers\Admin\UserController::class, 'edit'])->name('users.edit');
    Route::put('/utilisateurs/{user}', [\App\Http\Controllers\Admin\UserController::class, 'update'])->name('users.update');
    Route::get('/utilisateurs/{user}/commandes', [\App\Http\Controllers\Admin\UserController::class, 'orders'])->name('users.orders');
    Route::patch('/commandes/{order}/statut', [\App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::patch('/commandes/{order}/paiement', [\App\Http\Controllers\Admin\OrderController::class, 'updatePayment'])->name('orders.updatePayment');
    Route::post('/notifications/read/{id}', [\App\Http\Controllers\Admin\DashboardController::class, 'markNotificationRead'])->name('admin.notifications.read');
});

require __DIR__.'/auth.php';
