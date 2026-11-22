@extends('layouts.app')

@section('content')
    @php
        $productImages = [
            'Laptop' => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?auto=format&fit=crop&w=300&q=80',
            'Mouse' => 'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?auto=format&fit=crop&w=300&q=80',
            'Keyboard' => 'https://images.unsplash.com/photo-1587829741301-dc798b83add3?auto=format&fit=crop&w=300&q=80',
            'Monitor' => 'https://images.unsplash.com/photo-1527443224154-c4a3942d3acf?auto=format&fit=crop&w=300&q=80',
        ];
        $defaultImage = 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=300&q=80';
    @endphp

    <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200/80 shadow-sm max-w-3xl mx-auto">
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-5 rounded-xl mb-6 flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-emerald-600 text-white flex items-center justify-center shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <div>
                <h1 class="text-xl font-extrabold">{{ session('success') ?? 'Order Placed Successfully!' }}</h1>
                <p class="text-sm text-emerald-700">Thank you for your purchase. Your order details are below.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 bg-slate-50 p-4 rounded-xl border border-slate-200/70 mb-6 text-sm">
            <p><span class="text-slate-500">Order ID:</span> <strong class="text-slate-900">{{ $order->order_code }}</strong></p>
            <p><span class="text-slate-500">Customer Name:</span> <strong class="text-slate-900">{{ $order->customer->first_name }} {{ $order->customer->last_name }}</strong></p>
            <p><span class="text-slate-500">Order Date:</span> <strong class="text-slate-900">{{ $order->created_at->format('Y-m-d H:i') }}</strong></p>
            <p><span class="text-slate-500">Order Status:</span>
                <span class="px-2.5 py-0.5 bg-amber-100 text-amber-800 rounded-full text-xs font-bold">{{ $order->status }}</span>
            </p>
        </div>

        <h2 class="font-bold text-lg text-slate-900 mb-3">Ordered Products</h2>
        <div class="divide-y divide-slate-100 border border-slate-200 rounded-xl overflow-hidden mb-6">
            @foreach($order->items as $item)
                <div class="p-4 flex items-center justify-between gap-4 bg-white">
                    <div class="flex items-center gap-3.5">
                        <img src="{{ $productImages[$item->product->name] ?? $defaultImage }}"
                             alt="{{ $item->product->name }}"
                             class="w-14 h-14 rounded-xl object-cover border border-slate-200 shrink-0">
                        <div>
                            <p class="font-bold text-slate-900">{{ $item->product->name }}</p>
                            <p class="text-xs text-slate-500">Qty: {{ $item->quantity }} × ${{ number_format($item->unit_price, 2) }}</p>
                        </div>
                    </div>
                    <span class="font-bold text-slate-900">${{ number_format($item->line_total, 2) }}</span>
                </div>
            @endforeach
        </div>

        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 border-t border-slate-100 pt-5">
            <div>
                <p class="text-xs text-slate-500">Shipping: {{ $order->shipping_method }} (${{ number_format($order->shipping_fee, 2) }})</p>
                <p class="text-xl font-extrabold text-indigo-600 mt-0.5">Total Amount: ${{ number_format($order->total_amount, 2) }}</p>
            </div>
            <a href="{{ route('shop.index') }}"
               class="bg-indigo-600 text-white px-6 py-2.5 rounded-xl text-sm font-semibold hover:bg-indigo-700 transition">
                Continue Shopping
            </a>
        </div>
    </div>
@endsection