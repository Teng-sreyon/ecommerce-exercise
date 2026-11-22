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

    <div class="mb-6">
        <a href="{{ route('cart.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-700">
            ← Back to Shopping Cart
        </a>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-2">Checkout</h1>
        <p class="text-sm text-slate-500">Complete your shipping details and choose a delivery method.</p>
    </div>

    @if($errors->any())
        <div class="mb-6 p-4 rounded-2xl bg-rose-50 text-rose-800 border border-rose-200">
            <p class="font-bold text-sm mb-1">Please fix the following errors:</p>
            <ul class="list-disc list-inside text-sm space-y-0.5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('checkout.place') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
        @csrf

        <!-- Left Column: Customer Info & Shipping Method -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 sm:p-8 space-y-6">
            <div>
                <h2 class="text-lg font-extrabold text-slate-900 border-b border-slate-100 pb-3 mb-4">
                    Customer Information
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">First Name *</label>
                        <input type="text" name="first_name" value="{{ old('first_name') }}" required placeholder="e.g. Sokha"
                               class="w-full border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Last Name *</label>
                        <input type="text" name="last_name" value="{{ old('last_name') }}" required placeholder="e.g. Chan"
                               class="w-full border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Email *</label>
                        <input type="email" name="email" value="{{ old('email') }}" required placeholder="name@example.com"
                               class="w-full border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Phone Number *</label>
                        <input type="text" name="phone_number" value="{{ old('phone_number') }}" required placeholder="+855 12 345 678"
                               class="w-full border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>

                <div class="mt-4">
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Shipping Address *</label>
                    <textarea name="address" rows="3" required placeholder="Street, Sangkat, Khan, City..."
                              class="w-full border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">{{ old('address') }}</textarea>
                </div>
            </div>

            <div>
                <h2 class="text-lg font-extrabold text-slate-900 border-b border-slate-100 pb-3 mb-4">
                    Shipping Method *
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <label class="flex items-center justify-between border border-slate-200 hover:border-indigo-400 p-4 rounded-xl cursor-pointer transition bg-slate-50/50">
                        <div class="flex items-center gap-3">
                            <input type="radio" name="shipping_method" value="Free Shipping"
                                   {{ old('shipping_method', 'Free Shipping') === 'Free Shipping' ? 'checked' : '' }}
                                   onchange="updateTotal()" class="text-indigo-600 focus:ring-indigo-500">
                            <div>
                                <p class="text-sm font-bold text-slate-900">Free Shipping</p>
                                <p class="text-xs text-slate-500">5–7 Business Days</p>
                            </div>
                        </div>
                        <span class="text-sm font-extrabold text-emerald-600">$0.00</span>
                    </label>

                    <label class="flex items-center justify-between border border-slate-200 hover:border-indigo-400 p-4 rounded-xl cursor-pointer transition bg-slate-50/50">
                        <div class="flex items-center gap-3">
                            <input type="radio" name="shipping_method" value="Express Shipping"
                                   {{ old('shipping_method') === 'Express Shipping' ? 'checked' : '' }}
                                   onchange="updateTotal()" class="text-indigo-600 focus:ring-indigo-500">
                            <div>
                                <p class="text-sm font-bold text-slate-900">Express Shipping</p>
                                <p class="text-xs text-slate-500">1–2 Business Days</p>
                            </div>
                        </div>
                        <span class="text-sm font-extrabold text-indigo-600">$9.00</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Right Column: Order Summary with Product Thumbnails -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 sticky top-24 space-y-4">
            <h2 class="text-lg font-extrabold text-slate-900 border-b border-slate-100 pb-3">
                Order Summary
            </h2>

            <div class="space-y-3 max-h-64 overflow-y-auto pr-1">
                @foreach($cart as $item)
                    <div class="flex items-center justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <img src="{{ $productImages[$item['name']] ?? $defaultImage }}"
                                 alt="{{ $item['name'] }}"
                                 class="w-12 h-12 rounded-lg object-cover border border-slate-200">
                            <div>
                                <p class="text-sm font-bold text-slate-900">{{ $item['name'] }}</p>
                                <p class="text-xs text-slate-500">Qty: {{ $item['quantity'] }}</p>
                            </div>
                        </div>
                        <span class="text-sm font-bold text-slate-800">
                            ${{ number_format($item['price'] * $item['quantity'], 2) }}
                        </span>
                    </div>
                @endforeach
            </div>

            <div class="border-t border-slate-100 pt-4 space-y-2 text-sm">
                <div class="flex justify-between text-slate-600">
                    <span>Subtotal</span>
                    <span id="subtotal-val" data-subtotal="{{ $subtotal }}" class="font-semibold text-slate-900">
                        ${{ number_format($subtotal, 2) }}
                    </span>
                </div>
                <div class="flex justify-between text-slate-600">
                    <span>Shipping</span>
                    <span id="shipping-val" class="font-semibold text-slate-900">$0.00</span>
                </div>
                <div class="flex justify-between items-center border-t border-slate-200 pt-3 mt-2">
                    <span class="text-base font-bold text-slate-900">Grand Total</span>
                    <span id="grand-total-val" class="text-xl font-extrabold text-indigo-600">
                        ${{ number_format($subtotal, 2) }}
                    </span>
                </div>
            </div>

            <button type="submit"
                    class="w-full bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-700 hover:to-violet-700 text-white py-3 rounded-xl text-sm font-bold shadow-md transition cursor-pointer">
                Place Order
            </button>
        </div>
    </form>

    <script>
        function updateTotal() {
            const subtotal = parseFloat(document.getElementById('subtotal-val').dataset.subtotal);
            const selected = document.querySelector('input[name="shipping_method"]:checked');
            const shipping = selected && selected.value === 'Express Shipping' ? 9.00 : 0.00;
            const total = subtotal + shipping;

            document.getElementById('shipping-val').textContent = '$' + shipping.toFixed(2);
            document.getElementById('grand-total-val').textContent = '$' + total.toFixed(2);
        }
        updateTotal();
    </script>
@endsection