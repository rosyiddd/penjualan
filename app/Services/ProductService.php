<?php

namespace App\Services;
use App\Models\Product;

class ProductService {

    public function all()
    {
        $products = [];
        foreach(Product::all() as $product){
            if($product->discount > 0){
                $product->priceAfterDiscount = $this->hitungDiskon($product);
            }
            $products[] = $product;
        }
        return $products;
    }
    public function get(String $productCode):Product
    {
        $product = Product::firstWhere('product_code', $productCode);
        $product->priceAfterDiscount = $this->hitungDiskon($product);
        return $product;
    }
    private function hitungDiskon($product){
        $discount = ($product->price * $product->discount / 100);
        return $product->price - $discount;
    }
}