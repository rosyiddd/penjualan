<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private ProductService $productService;

    public function __construct(){
        $this->productService = new ProductService;
    }

    public function showAllProducts(){
        $products = $this->productService->all();
        return view('product', [
            'title' => "Product List",
            'products' => $products
        ]);
    }

    public function getProduct(String $productCode){
        $product = $this->productService->get($productCode);
        return view('product-detail', [
            'title' => "Product Detail",
            'item' => $product
        ]);
    }
    public function getProductJson(String $productCode){
        $product = $this->productService->get($productCode);
        return response()->json($product);
    }
}
