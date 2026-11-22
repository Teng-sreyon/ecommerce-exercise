@extends('layouts.app')

@section('content')
    @php
        $productImages = [
            'Laptop' => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?auto=format&fit=crop&w=400&q=80',
            'Mouse' => 'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?auto=format&fit=crop&w=400&q=80',
            'Keyboard' => 'https://images.unsplash.com/photo-1587829741301-dc798b83add3?auto=format&fit=crop&w=400&q=80',
            'Monitor' => 'https://images.unsplash.com/photo-1527443224154-c4a3942d3acf?auto=format&fit=crop&w=400&q=80',
        ];
        $defaultImage = 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=400&q=80';
    @endphp

    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Shopping Cart</h1>
            <p class="text-sm text-slate-500 mt-1">Review your selected items, adjust quantities, or proceed to checkout.</p>
        </div>
        <a href="{{ route('shop.index') }}"
           class="inline-flex items-center gap-2 text-sm font-semibold text-indigo-600 hover:text-indigo-700 transition">
            <span>← Continue Shopping</span>
        </a>
    </div>

    @if(empty($cart))
        <!-- Empty Cart State -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-12 text-center max-w-lg mx-auto">
            <div class="w-16 h-16 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center mx-auto mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <h2 class="text-lg font-bold text-slate-900">Your shopping cart is empty</h2>
            <p class="text-sm text-slate-500 mt-1 mb-6">Looks like you haven’t added any tech gear yet.</p>
            <a href="{{ route('shop.index') }}"
               class="inline-block bg-indigo-600 text-white px-6 py-2.5 rounded-xl text-sm font-semibold hover:bg-indigo-700 shadow-sm transition">
                Browse Products
            </a>
        </div>
    @else
        <!-- 2-Column Layout: Cart Items + Order Summary -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

            <!-- Left Column: Cart Items List -->
            <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200/80 shadow-sm divide-y divide-slate-100 overflow-hidden">
                <div class="px-6 py-4 bg-slate-50/70 border-b border-slate-200/70 flex justify-between items-center">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-500">
                        Cart Items ({{ collect($cart)->sum('quantity') }})
                    </span>
                    <span class="text-xs font-medium text-slate-400">Unit Price & Line Total</span>
                </div>

                @foreach($cart as $item)
                    <div class="p-5 sm:p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-slate-50/50 transition">
                        <!-- Product Image + Name + Unit Price -->
                        <div class="flex items-center gap-4">
                            <div class="w-20 h-20 rounded-xl bg-slate-100 border border-slate-200/80 overflow-hidden shrink-0">
                                <img src="{{ $productImages[$item['name']] ?? $defaultImage }}"
                                     alt="{{ $item['name'] }}"
                                     class="w-full h-full object-cover">
                            </div>
                            <div>
                                <h3 class="text-base sm:text-lg font-bold text-slate-900">{{ $item['name'] }}</h3>
                                <p class="text-sm text-slate-500 mt-0.5">
                                    Unit Price: <span class="font-semibold text-slate-700">${{ number_format($item['price'], 2) }}</span>
                                </p>
                                <span class="inline-block mt-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">
                                    In Stock
                                </span>
                            </div>
                        </div>

                        <!-- Quantity Update + Line Total + Remove -->
                        <div class="flex flex-wrap sm:flex-nowrap items-center justify-between sm:justify-end gap-4 pt-3 sm:pt-0 border-t sm:border-t-0 border-slate-100">
                            <!-- Update Quantity Form -->
                            <form action="{{ route('cart.update', $item['id']) }}" method="POST" class="flex items-center gap-2">
                                @csrf
                                @method('PATCH')
                                <label class="sr-only">Quantity</label>
                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1"
                                       class="w-16 text-center border border-slate-300 rounded-xl px-2.5 py-1.5 text-sm font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <button type="submit"
                                        class="px-3 py-1.5 rounded-xl text-xs font-semibold bg-indigo-50 text-indigo-700 hover:bg-indigo-600 hover:text-white transition cursor-pointer">
                                    Update
                                </button>
                            </form>

                            <!-- Line Total -->
                            <div class="text-right min-w-[85px]">
                                <p class="text-xs text-slate-400">Total</p>
                                <p class="text-base font-extrabold text-slate-900">
                                    ${{ number_format($item['price'] * $item['quantity'], 2) }}
                                </p>
                            </div>

                            <!-- Remove Button -->
                            <form action="{{ route('cart.remove', $item['id']) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="Remove item"
                                        class="p-2 rounded-xl text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Right Column: Order Summary Card -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 sticky top-24">
                <h2 class="text-lg font-extrabold text-slate-900 border-b border-slate-100 pb-3 mb-4">
                    Order Summary
                </h2>

                <div class="space-y-3 text-sm">
                    <div class="flex justify-between text-slate-600">
                        <span>Subtotal</span>
                        <span class="font-semibold text-slate-900">${{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-slate-600">
                        <span>Estimated Shipping</span>
                        <span class="text-emerald-600 font-medium">Calculated at checkout</span>
                    </div>
                </div>

                <div class="border-t border-slate-200 my-4 pt-4 flex justify-between items-center">
                    <span class="text-base font-bold text-slate-900">Grand Total</span>
                    <span class="text-2xl font-extrabold text-indigo-600">${{ number_format($grandTotal, 2) }}</span>
                </div>

                <a href="{{ route('checkout.index') }}"
                   class="w-full mt-2 inline-flex items-center justify-center gap-2 bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-700 hover:to-violet-700 text-white py-3 px-5 rounded-xl text-sm font-bold shadow-md transition">
                    <span>Proceed to Checkout</span>
                    <span>→</span>
                </a>
            </div>
        </div>
    @endif
@endsection