<?php

namespace App\Http\Controllers;

use App\Models\sale;
use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SaleController extends Controller
{
    public function newSale(Request $req)
    {
        $sale = sale::create($req->all());
        $product = product::find($req->input('product_id'));
        if ($product) {
            $newStock = $product->stock - $req->input('amount');
            $product->update(['stock' => $newStock]);
        }
        return response($sale, 200);
    }
    public function getSales()
    {
        return response()->json(sale::all(), 200);
    }
    public function getSaleById($id)
    {
        $sale = sale::find($id);
        if (is_null($sale)) {
            return response()->json(['msn' => 'Sale not found'], 404);
        }
        return response()->json($sale, 200);
    }
    public function deleteSaleById($id)
    {
        $sale = sale::find($id);
        if (is_null($sale)) {
            return response()->json(['msn' => 'Sale not found'], 404);
        }
        $sale->delete();
        return response()->json(['msn' => 'Sale deleted'], 200);
    }

public function getProductosmasvendidos()
{
    try {
        $result = DB::table('sales')
            ->join('products', 'sales.product_id', '=', 'products.id')
            ->select(
                'products.id',
                'products.name',
                'products.price',
                'products.price_sale',
                'products.stock',
                'products.expired',
                'products.image',
                'products.state',
                'products.category_id',
                DB::raw('COUNT(sales.product_id) as frequency')
            )
            ->groupBy(
                'products.id',
                'products.name',
                'products.price',
                'products.price_sale',
                'products.stock',
                'products.expired',
                'products.image',
                'products.state',
                'products.category_id'
            )
            ->orderByDesc('frequency')  // Ordenar por la frecuencia descendente
            ->get();

        // Construir la URL completa para la imagen sin acceder a la carpeta public
        foreach ($result as $item) {
            $item->image = asset(Storage::url($item->image));
        }

        return response()->json($result, 200);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}
    //
}
