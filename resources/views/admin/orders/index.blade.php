@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Liste des commandes</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Client</th>
                <th>Total</th>
                <th>Status</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->user ? $order->user->name : '-' }}</td>
                    <td>{{ number_format($order->total, 0, ',', ' ') }} F CFA</td>
                    <td>{{ $order->status }}</td>
                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-primary">Voir</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection 