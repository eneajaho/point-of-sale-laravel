<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceProducts;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{

    public function index(Request $request) {
        $invoices = Invoice::with('user', 'invoiceProducts.product')->get();

        return response()->json($invoices);
    }

    public function create(Request $request)
    {
//        return response()->json($request->items);

        $invoice = new Invoice();
        $invoice->user_id = Auth::user()->id;
        $invoice->shift_id = 1; // TODO: fix later
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
            array_push($items, $invoiceItem);
        }
//        return response()->json($items);
//        InvoiceProducts::create($items);

        $invoice->total = $totalPrice;
        $invoice->save();

        return response()->json([
            'invoice' => $invoice,
            'items' => $items
        ]);
    }
}
