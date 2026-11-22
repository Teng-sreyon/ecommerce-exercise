<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Shop | Laravel Store</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col">

    <!-- Navbar with Logo -->
    <nav class="sticky top-0 z-50 bg-white/95 backdrop-blur border-b border-slate-200 shadow-sm">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 h-16 flex justify-between items-center">
            <!-- Brand Logo -->
            <a href="{{ route('shop.index') }}" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-600 to-violet-600 flex items-center justify-center text-white font-bold shadow-md group-hover:scale-105 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
                <div>
                    <span class="text-xl font-extrabold tracking-tight text-slate-900">E-Shop</span>
                    <span class="hidden sm:block text-[11px] text-indigo-600 font-medium -mt-1">Tech & Accessories</span>
                </div>
            </a>

            <!-- Navigation Links -->
            <div class="flex items-center gap-4 sm:gap-6">
                <a href="{{ route('shop.index') }}"
                   class="text-sm font-semibold {{ request()->routeIs('shop.index') ? 'text-indigo-600' : 'text-slate-600 hover:text-indigo-600' }} transition">
                    Products
                </a>

                <a href="{{ route('cart.index') }}"
                   class="inline-flex items-center gap-2 px-3.5 py-2 rounded-full text-sm font-semibold bg-indigo-50 text-indigo-700 hover:bg-indigo-100 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span>Cart</span>
                    <span class="px-2 py-0.5 text-xs font-bold rounded-full bg-indigo-600 text-white">
                        {{ collect(session('cart', []))->sum('quantity') }}
                    </span>
                </a>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    <div class="max-w-6xl w-full mx-auto px-4 sm:px-6 mt-4">
        @if(session('success'))
            <div class="p-4 rounded-xl bg-emerald-50 text-emerald-800 border border-emerald-200 flex items-center justify-between shadow-sm">
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 rounded-xl bg-rose-50 text-rose-800 border border-rose-200 flex items-center justify-between shadow-sm">
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        @endif
    </div>

    <!-- Main Content -->
    <main class="flex-1 max-w-6xl w-full mx-auto px-4 sm:px-6 py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-300 border-t border-slate-800 mt-auto">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-10 grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <div class="flex items-center gap-2.5 mb-3">
                    <div class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center text-white font-bold">
                        E
                    </div>
                    <span class="text-lg font-bold text-white">E-Shop</span>
                </div>
                <p class="text-sm text-slate-400 leading-relaxed">
                    Simple Laravel E-Commerce practice store with product catalog, shopping cart, checkout, and order confirmation.
                </p>
            </div>

            <div>
                <h3 class="text-sm font-semibold uppercase tracking-wider text-white mb-3">Quick Links</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('shop.index') }}" class="hover:text-indigo-400 transition">Products Catalog</a></li>
                    <li><a href="{{ route('cart.index') }}" class="hover:text-indigo-400 transition">Shopping Cart</a></li>
                    <li><a href="{{ route('checkout.index') }}" class="hover:text-indigo-400 transition">Checkout</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-sm font-semibold uppercase tracking-wider text-white mb-3">Contact & Support</h3>
                <p class="text-sm text-slate-400">Email: support@eshop.local</p>
                <p class="text-sm text-slate-400 mt-1">Phone: +855 12 345 678</p>
                <p class="text-sm text-slate-400 mt-1">Phnom Penh, Cambodia</p>
            </div>
        </div>

        <div class="border-t border-slate-800 py-4 text-center text-xs text-slate-500">
            © {{ date('Y') }} E-Shop Laravel Exercise. All rights reserved.
        </div>
    </footer>

</body>
</html>