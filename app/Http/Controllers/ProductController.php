<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    //
    /* public function newProduct(Request $request)
    {
        $product = product::create($request->all());
        return response($product, 200);
    } */

    public function getProducts()
    {
        $products = Product::where('state', 1)->get();
        foreach ($products as $product) {
            $product->image = asset(Storage::url($product->image));
        }
        return response()->json($products, 200);
    }

    public function newProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'price' => 'required|numeric',
            'price_sale' => 'required|numeric',
            'stock' => 'required',
            'expired' => 'required',
            'category_id' => 'required',
            'image' => 'required|image|max:2048',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $rutaArchivoImg = $request->file('image')->store('public/imgproductos');
        $producto = Product::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'price_sale' => $request->price_sale,
            'image' => $rutaArchivoImg,
            'stock' => $request->stock,
            'expired' => $request->expired,
        ]);

        return response()->json(['producto' => $producto], 201);
    }

    public function deleteProductById($id)
    {
        if ($product = Product::find($id)) {
            $product->state = 0;
            $product->save();
            return response()->json(['success' => true]);
        } else {
            return response()->json(['error' => 'Producto no encontrado'], 404);
        }
    }
    public function updateProductById(Request $request, $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }
        $validator = Validator::make($request->all(), [
            'name' => 'string|max:50',
            'price' => 'numeric',
            'price_sale' => 'numeric',
            'stock' => 'numeric|nullable',
            'expired' => 'nullable',
            'category_id' => 'numeric|nullable',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        if ($request->hasFile('image')) {
            // Si se envía una nueva imagen, se elimina la imagen anterior y se almacena la nueva.
            if ($product->image) {
                Storage::delete($product->image);
            }
            $rutaArchivoImg = $request->file('image')->store('public/imgproductos');
            $product->image = $rutaArchivoImg;
        }
        $fieldsToUpdate = ['name', 'category_id', 'price', 'price_sale', 'stock', 'expired'];
        foreach ($fieldsToUpdate as $field) {
            if ($request->has($field)) {
                $product->$field = $request->input($field);
            }
        }
        $product->save();
        return response()->json(['message' => 'Producto actualizado con éxito'], 200);
    }


    public function updateStock($id, Request $request)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        $newStock = $request->input('stock');

        $product->stock = $newStock;
        $product->save();

        return response()->json(['message' => 'Stock actualizado correctamente']);
    }

    public function getProductById($id)
    {
        $product = Product::find($id);
        if (is_null($product)) {
            return response()->json(['msn' => 'Product not found'], 404);
        }
        return response()->json($product, 200);
    }
}
