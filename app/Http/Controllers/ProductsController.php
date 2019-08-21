<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Product;
use App\Category;
use App\SubCategory;

class ProductsController extends Controller
{
  public function index()
	{
    if (isset($_GET['orderBy'])) {
      switch ($_GET['orderBy']) {
        case 'PRICE_DESC':
          $products = Product::orderBy('price', 'ASC')->get();
          break;
        case 'PRICE_ASC':
          $products = Product::orderBy('price', 'DESC')->get();
          break;
        case 'RATING_ASC':
          $products = Product::orderBy('rating', 'ASC')->get();
          break;
        case 'RATING_DESC':
          $products = Product::orderBy('rating', 'DESC')->get();
          break;
        default:
          $products = Product::all();
        break;
      }
    } else {
      $products = Product::all();
    }
    $subcategories = SubCategory::orderBy('name', 'ASC')->get();
		return view('products', compact('products', 'subcategories'));
	}

  public function search(){
    $subcategories = SubCategory::orderBy('name', 'ASC')->get();
    $products = Product::where('title', 'like', '%' . $_GET['query'] . '%')->get();
    return view('products', compact('products', 'subcategories'));
  }

  public function show ($id)
  {
  $subcategories = SubCategory::orderBy('name', 'ASC')->get();
  $productToFind = Product::find($id);
  return view('productDetail', compact('productToFind', 'subcategories'));
  }

  public function dogs() {
    $subcategories = SubCategory::orderBy('name', 'ASC')->get();
    $products = Product::where("category_id", "=", "1")
    ->orderBy('price', 'ASC')
    ->get();
    return view('products', compact('products', 'subcategories'));
  }

  public function cats() {
    $subcategories = SubCategory::orderBy('name', 'ASC')->get();
    $products = Product::where("category_id", "=", "2")
      ->get();
    return view('products', compact('products', 'subcategories'));
  }

  public function food() {
    $subcategories = SubCategory::orderBy('name', 'ASC')->get();
    $products = Product::where("subcategory_id", "=", "1")
      ->get();
    return view('products', compact('products', 'subcategories'));
  }

  public function accesories() {
    $subcategories = SubCategory::orderBy('name', 'ASC')->get();
    $products = Product::where("subcategory_id", "=", "2")
      ->get();
    return view('products', compact('products', 'subcategories'));
  }

  public function hygiene() {
    $subcategories = SubCategory::orderBy('name', 'ASC')->get();
    $products = Product::where("subcategory_id", "=", "4")
      ->get();
    return view('products', compact('products', 'subcategories'));
  }

  public function snacks() {
    $subcategories = SubCategory::orderBy('name', 'ASC')->get();
    $products = Product::where("subcategory_id", "=", "3")
      ->get();
    return view('products', compact('products', 'subcategories'));
  }

  public function health() {
    $subcategories = SubCategory::orderBy('name', 'ASC')->get();
    $products = Product::where("subcategory_id", "=", "5")
      ->get();
    return view('products', compact('products', 'subcategories'));
  }

}
