<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    // Exercise 1: Display the 4 products + Add to Cart
    public function index()
    {
        $products = Product::all();
        $cart = session()->get('cart', []);

        return view('shop.index', compact('products', 'cart'));
    }

    public function addToCart(Request $request, Product $product)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => (float) $product->price,
                'quantity' => 1,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', "{$product->name} added to cart!");
    }

    // Exercise 1 (Shopping Cart): View, Update QTY, Remove, Subtotal & Grand Total
    public function cart()
    {
        $cart = session()->get('cart', []);
        $subtotal = $this->calculateSubtotal($cart);
        $grandTotal = $subtotal;

        return view('shop.cart', compact('cart', 'subtotal', 'grandTotal'));
    }

    public function updateCart(Request $request, int $productId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] = (int) $request->quantity;
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Quantity updated.');
    }

    public function removeCart(int $productId)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Item removed from cart.');
    }

    // Exercise 2: Checkout Form & Order Placement
    public function checkout()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('shop.index')->with('error', 'Your cart is empty.');
        }

        $subtotal = $this->calculateSubtotal($cart);
        $shippingOptions = [
            'Free Shipping' => 0.00,
            'Express Shipping' => 9.00,
        ];

        return view('shop.checkout', compact('cart', 'subtotal', 'shippingOptions'));
    }

    public function placeOrder(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('shop.index')->with('error', 'Your cart is empty.');
        }

        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'phone_number' => 'required|string|max:30',
            'address' => 'required|string|max:500',
            'shipping_method' => 'required|in:Free Shipping,Express Shipping',
        ]);

        $shippingFee = $validated['shipping_method'] === 'Express Shipping' ? 9.00 : 0.00;
        $subtotal = $this->calculateSubtotal($cart);
        $totalAmount = $subtotal + $shippingFee;

        $order = DB::transaction(function () use ($validated, $cart, $shippingFee, $subtotal, $totalAmount) {
            $customer = Customer::create([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'phone_number' => $validated['phone_number'],
                'address' => $validated['address'],
            ]);

            $nextNumber = (Order::max('id') ?? 0) + 1;
            $orderCode = 'ORD-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

            $order = Order::create([
                'order_code' => $orderCode,
                'customer_id' => $customer->id,
                'shipping_method' => $validated['shipping_method'],
                'shipping_fee' => $shippingFee,
                'subtotal' => $subtotal,
                'total_amount' => $totalAmount,
                'status' => 'Pending',
            ]);

            foreach ($cart as $item) {
                $lineTotal = $item['price'] * $item['quantity'];

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['price'],
                    'line_total' => $lineTotal,
                ]);
            }

            return $order;
        });

        session()->forget('cart');

        return redirect()->route('order.confirmation', $order->id)
            ->with('success', 'Order Placed Successfully!');
    }

    // Exercise 3: Order Confirmation
    public function confirmation(Order $order)
    {
        $order->load(['customer', 'items.product']);

        return view('shop.confirmation', compact('order'));
    }

    private function calculateSubtotal(array $cart): float
    {
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        return round($subtotal, 2);
    }
}