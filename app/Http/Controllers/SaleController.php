<?php

namespace App\Http\Controllers;

use App\Models\sale;
use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SaleController extends Controller
{

    public function newSale(Request $req) {
        $sale = sale::create($req->all());
        $product=product::find($req->input('product_id'));
        if($product){
            $newStock=$product->stock-$req->input('amount');
            $product->update(['stock'=>$newStock]);
        }
        return response($sale, 200);
    }

    public function getSales() {
        return response()->json(sale::all(), 200);
    }

    public function getSaleById($id) {
        $sale = sale::find($id);
        if(is_null($sale)) {
            return response()->json(['msn' => 'Sale not found'], 404);
        }
        return response()->json($sale, 200);
    }

    public function deleteSaleById($id) {
        $sale = sale::find($id);
        if(is_null($sale)) {
            return response()->json(['msn' => 'Sale not found'], 404);
        }
        $sale->delete();
        return response()->json(['msn' => 'Sale deleted'], 200);
    }
    //
}
