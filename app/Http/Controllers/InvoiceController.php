<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceProducts;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Invoice::with('user', 'invoiceProducts.product');

        if ($request->has('user')) {
            $query->where('user_id', $request->user);
        }

        if ($request->has('isPaid')) {
            $query->where('is_paid', $request->isPaid);
        }

        if ($request->has('startDate')) {
            $startDate = Carbon::createFromFormat('Y-m-d', $request->startDate);
            $query->where('created_at', '>=', $startDate->startOfDay());
        }

        if ($request->has('endDate')) {
            $endDate = Carbon::createFromFormat('Y-m-d', $request->endDate);
            $query->where('created_at', '<=', $endDate->endOfDay());
        }

        $invoices = $query
            ->orderByDesc('created_at')
            ->paginate($request->pageSize ?? 20);
        return response()->json($invoices);
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['invoiceProducts.product.stock', 'user']);
        return response()->json($invoice);
    }

    public function create(Request $request)
    {
        $invoice = new Invoice();
        $invoice->user_id = Auth::user()->id;
        $invoice->shift_id = Auth::user()->shift_id ?? 1;
        $invoice->is_paid = false;
        $invoice->total = 0;
        $invoice->created_at = Carbon::now();

        $invoice->save();

        $items = array();
        $totalPrice = 0;

        foreach ($request->items as $item) {
            $invoiceItem = new InvoiceProducts();

            $invoiceItem->quantity = $item['quantity'];
            $invoiceItem->price = $item['price'];
            $invoiceItem->total = $item['price'] * $item['quantity'];
            $invoiceItem->product_id = $item['product_id'];
            $invoiceItem->invoice_id = $invoice->id;

            $totalPrice += $item['price'] * $item['quantity'];

            $invoiceItem->save();

            // decrease stock
            $product = Product::with('stock')->find($item['product_id']);
            $product->stock->quantity = $product->stock->quantity - $item['quantity'];
            $product->stock->save();

            array_push($items, $invoiceItem);
        }

        $invoice->total = $totalPrice;
        $invoice->save();

        return response()->json([
            'invoice' => $invoice,
            'items' => $items
        ]);
    }

    public function update(Request $request, Invoice $invoice)
    {
        $items = array();
        $totalPrice = 0;

        $invoice->load('invoiceProducts');

        // return stock for each invoice product to where it was
        $invoiceProducts = InvoiceProducts
            ::where('invoice_id', $invoice->id)
            ->with('product.stock')
            ->get();
        foreach ($invoiceProducts as $invoiceProduct) {
            $stock = $invoiceProduct->product->stock;
            $stock->quantity = $stock->quantity + $invoiceProduct->quantity;
            $stock->save();
        }

        // remove all current invoice products
        InvoiceProducts::where('invoice_id', $invoice->id)->delete();

        // add all new invoice products
        foreach ($request->items as $item) {
            $invoiceItem = new InvoiceProducts();

            $invoiceItem->quantity = $item['quantity'];
            $invoiceItem->price = $item['price'];
            $invoiceItem->total = $item['price'] * $item['quantity'];
            $invoiceItem->product_id = $item['product_id'];
            $invoiceItem->invoice_id = $invoice->id;

            $totalPrice += $item['price'] * $item['quantity'];

            $invoiceItem->save();

            // decrease stock
            $product = Product::with('stock')->find($item['product_id']);
            $product->stock->quantity = $product->stock->quantity - $item['quantity'];
            $product->stock->save();

            array_push($items, $invoiceItem);
        }

        $invoice->total = $totalPrice;
        $invoice->save();

        return response()->json([
            'invoice' => $invoice,
            'items' => $items
        ]);
    }

    public function pay(Invoice $invoice) {
        $invoice->is_paid = true;
        $invoice->save();
        return response()->json($invoice);
    }
}
