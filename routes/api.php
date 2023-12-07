<?php
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(CategoryController::class)->group(function(){
    Route::post('nuevaCategoria', 'newCategory');
    Route::get('categorias', 'getCategories');
    Route::get('categoria/{id}', 'getCategoryById');
    Route::delete('eliminarCategoria/{id}', 'deleteCategoryById');
});

Route::controller(ProductController::class)-> group(function(){
    Route::post('nuevoProducto', 'newProduct');
    Route::get('productos', 'getProducts');
    Route::get('producto/{id}', 'getProductById');
    Route::delete('eliminarProducto/{id}', 'deleteProductById');
    Route::post('actualizarProducto/{id}', 'updateProductById');
    Route::post('actualizarProductoStock/{id}', 'updateStock');

    //updateStock

});

Route::controller(SaleController::class)->group(function(){
    Route::post('nuevaVenta', 'newSale');
    Route::get('ventas', 'getSales');
    Route::get('venta/{id}', 'getSaleById');
    Route::delete('eliminarVenta/{id}', 'deleteSaleById');
    Route::post('actualizarVenta/{id}', 'updateSaleById');
    Route::post('vetaProducto/{id}', 'vetaProductById');
    Route::get('productosmasvendidos','getProductosmasvendidos');
});
