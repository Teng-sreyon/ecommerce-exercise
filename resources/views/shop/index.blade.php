@extends('layouts.app')

@section('content')
    @php
        $productImages = [
            'Laptop' => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?auto=format&fit=crop&w=800&q=80',
            'Mouse' => 'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?auto=format&fit=crop&w=800&q=80',
            'Keyboard' => 'https://images.unsplash.com/photo-1587829741301-dc798b83add3?auto=format&fit=crop&w=800&q=80',
            'Monitor' => 'https://images.unsplash.com/photo-1527443224154-c4a3942d3acf?auto=format&fit=crop&w=800&q=80',
        ];
        $defaultImage = 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=800&q=80';
    @endphp

    <!-- Hero Section with Background Image -->
    <div class="relative rounded-2xl overflow-hidden mb-8 shadow-md bg-slate-900">
        <img src="https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=1400&q=80"
             alt="Tech Background"
             class="w-full h-52 sm:h-64 object-cover opacity-35">
        <div class="absolute inset-0 bg-gradient-to-r from-slate-950/85 via-slate-900/70 to-transparent flex flex-col justify-center p-6 sm:p-10">
            <span class="inline-block w-fit px-3 py-1 rounded-full text-xs font-semibold bg-indigo-500/20 text-indigo-300 border border-indigo-400/30 mb-3">
                New Collection
            </span>
            <h1 class="text-2xl sm:text-4xl font-extrabold text-white">Upgrade Your Workspace</h1>
            <p class="text-slate-300 text-sm sm:text-base mt-2 max-w-xl">
                Quality laptops, mice, mechanical keyboards, and monitors ready for your cart.
            </p>
            <div class="mt-5 flex items-center gap-3">
                <a href="{{ route('cart.index') }}"
                   class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-semibold shadow transition">
                    View Shopping Cart
                </a>
            </div>
        </div>
    </div>

    <!-- Products Section Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">Products</h2>
            <p class="text-sm text-slate-500">Choose items and click Add to Cart</p>
        </div>
        <a href="{{ route('cart.index') }}"
           class="bg-indigo-600 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-indigo-700 shadow-sm transition">
            View Cart
        </a>
    </div>

    <!-- 4 Product Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($products as $product)
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-lg transition overflow-hidden flex flex-col justify-between">
                <div>
                    <div class="h-44 bg-slate-100 overflow-hidden">
                        <img src="{{ $productImages[$product->name] ?? $defaultImage }}"
                             alt="{{ $product->name }}"
                             class="w-full h-full object-cover hover:scale-105 transition duration-300">
                    </div>

                    <div class="p-5">
                        <h3 class="text-lg font-bold text-slate-900">{{ $product->name }}</h3>
                        <p class="text-xl font-extrabold text-indigo-600 mt-1.5">
                            ${{ number_format($product->price, 2) }}
                        </p>
                    </div>
                </div>

                <div class="px-5 pb-5">
                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="w-full bg-slate-900 text-white py-2.5 rounded-xl text-sm font-semibold hover:bg-indigo-600 transition cursor-pointer">
                            Add to Cart
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@endsection