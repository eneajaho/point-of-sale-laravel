<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Models\Invoice;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $todayInvoices = Invoice::where('created_at', '>=', Carbon::today()->startOfDay());

        $sales = $todayInvoices->sum('total');

        $invoiceCount = $todayInvoices->count();

        $invoices = Invoice::where('created_at', '>=', Carbon::today()->startOfDay())
            ->with('invoiceProducts.product.category')
            ->get();

        $allInvoicesProducts = []; // for today
        foreach ($invoices as $invoice) {
            $products = $invoice->invoiceProducts;
            $allInvoicesProducts = array_merge($allInvoicesProducts, $products->toArray());
        }

        $invoiceProductsGroupedByCategory = Helpers::groupBy($allInvoicesProducts,
            fn($invoiceProduct) => $invoiceProduct['product']['category']['name']
        );

        $productsSoldForEachCategory = [];
        foreach ($invoiceProductsGroupedByCategory as $categoryName => $invoices) {
            array_push($productsSoldForEachCategory, [
                'name' => $categoryName,
                'value' => count($invoices)
            ]);
        }

        // most sold products
        $productsSales = []; // this is of type [key => value]
        foreach ($allInvoicesProducts as $invoiceProduct) {
            $productId = $invoiceProduct['product']['id'];
            if (array_key_exists($productId, $productsSales)) {
                $productsSales[$productId] = [
                    'id' => $productId,
                    'name' => $invoiceProduct['product']['name'],
                    'value' => $productsSales[$productId]['value'] + $invoiceProduct['quantity']
                ];
            } else {
                $productsSales[$productId] = [
                    'id' => $productId,
                    'name' => $invoiceProduct['product']['name'],
                    'value' => $invoiceProduct['quantity']
                ];
            }
        }

        // convert productSales to list
        $productsSalesList = [];
        foreach ($productsSales as $key => $value) {
            array_push($productsSalesList, $value);
        }
        // frontend will have to sort and select top 5 of them

        // products below minimum stock
        $lowStockProducts = Product::with(['stock'])
            ->whereHas('stock', function ($q) {
                $q->whereColumn('quantity', '<=', 'products.low_stock');
            })->get();

        $response = [
            'sales' => $sales,
            'invoiceCount' => $invoiceCount,
            'productSales' => $productsSalesList,
            'salesByCategory' => $productsSoldForEachCategory,
            'lowStockProducts' => $lowStockProducts
        ];

        return response()->json($response);
    }
}
