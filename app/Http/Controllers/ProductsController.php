<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Product;
use App\Category;
use App\SubCategory;
use App\Favorite;
use Auth;

class ProductsController extends Controller
{
    public function index()
    {
        if (isset($_GET['orderBy'])) {
            switch ($_GET['orderBy']) {
        case 'TITLE_ASC':
          $products = Product::orderBy('title', 'ASC')->get();
          break;
        case 'TITLE_DESC':
          $products = Product::orderBy('title', 'DESC')->get();
          break;
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
        case 'CREATED_AT_ASC':
          $products = Product::orderBy('created_at', 'ASC')->get();
          break;
        case 'CREATED_AT_DESC':
          $products = Product::orderBy('created_at', 'DESC')->get();
          break;
        default:
          $products = Product::all();
        break;
      }
        } else {
            $products = Product::all();
        }
        $categories = Category::orderBy('name', 'ASC')->get();
        $subcategories = SubCategory::orderBy('name', 'ASC')->get();
        if (Auth::guest()) {
            return view('products', compact('products', 'subcategories', 'categories'));
        } else {
            $favoritesProductsId = [];
            $favorites = Favorite::select('product_id')->where("user_id", "=", Auth::user()->id)->get();
            foreach ($favorites as $favorite) {
                $favoritesProductsId[] = $favorite->product_id;
            }
            return view('products', compact('products', 'subcategories', 'categories', 'favoritesProductsId'));
        }
    }

    public function listCategory($categoryID)
    {
        $products = Product::where('category_id', '=', $categoryID)->get();
        $currentCategory = Category::where('id', '=', $categoryID)->firstOrFail();
        $categories = Category::orderBy('name', 'ASC')->get();
        $subcategories = SubCategory::orderBy('name', 'ASC')->get();
        if (Auth::guest()) {
            return view('products', compact('products', 'subcategories', 'categories', 'currentCategory'));
        } else {
            $favoritesProductsId = [];
            $favorites = Favorite::select('product_id')->where("user_id", "=", Auth::user()->id)->get();
            foreach ($favorites as $favorite) {
                $favoritesProductsId[] = $favorite->product_id;
            }
            return view('products', compact('products', 'subcategories', 'categories', 'currentCategory', 'favoritesProductsId'));
        }
    }

    public function listSubCategory($SubCategoryID)
    {
        $categories = Category::orderBy('name', 'ASC')->get();
        $subcategories = SubCategory::orderBy('name', 'ASC')->get();
        $products = Product::where('subcategory_id', '=', $SubCategoryID)->get();
        if (Auth::guest()) {
            return view('products', compact('products', 'subcategories', 'categories'));
        } else {
            $favoritesProductsId = [];
            $favorites = Favorite::select('product_id')->where("user_id", "=", Auth::user()->id)->get();
            foreach ($favorites as $favorite) {
                $favoritesProductsId[] = $favorite->product_id;
            }
            return view('products', compact('products', 'subcategories', 'categories', 'favoritesProductsId'));
        }
    }

    public function listSubCategoryProducts($categoryID, $SubCategoryID)
    {
        $categories = Category::orderBy('name', 'ASC')->get();
        $subcategories = SubCategory::orderBy('name', 'ASC')->get();
        $products = Product::where([
      ['subcategory_id','=', $SubCategoryID],
      ['category_id','=', $categoryID],
      ])->get();

        if (Auth::guest()) {
            return view('products', compact('products', 'subcategories', 'categories'));
        } else {
            $favoritesProductsId = [];
            $favorites = Favorite::select('product_id')->where("user_id", "=", Auth::user()->id)->get();
            foreach ($favorites as $favorite) {
                $favoritesProductsId[] = $favorite->product_id;
            }
            return view('products', compact('products', 'subcategories', 'categories', 'favoritesProductsId'));
        }
    }

    public function search()
    {
        $categories = Category::orderBy('name', 'ASC')->get();
        $subcategories = SubCategory::orderBy('name', 'ASC')->get();
        $products = Product::where('title', 'like', '%' . $_GET['query'] . '%')->get();
        if (Auth::guest()) {
            return view('products', compact('products', 'subcategories', 'categories'));
        } else {
            $favoritesProductsId = [];
            $favorites = Favorite::select('product_id')->where("user_id", "=", Auth::user()->id)->get();
            foreach ($favorites as $favorite) {
                $favoritesProductsId[] = $favorite->product_id;
            }
            return view('products', compact('products', 'subcategories', 'categories', 'favoritesProductsId'));
        }
    }

    public function show($id)
    {
        $subcategories = SubCategory::orderBy('name', 'ASC')->get();
        $productToFind = Product::find($id);
        return view('productDetail', compact('productToFind', 'subcategories'));
    }

    public function offer()
    {
        $categories = Category::orderBy('name', 'ASC')->get();
        $subcategories = SubCategory::orderBy('name', 'ASC')->get();
        $products = Product::where("offer", "=", "1")
    ->orderBy('price', 'ASC')
    ->get();
        if (Auth::guest()) {
            return view('products', compact('products', 'subcategories', 'categories'));
        } else {
            $favoritesProductsId = [];
            $favorites = Favorite::select('product_id')->where("user_id", "=", Auth::user()->id)->get();
            foreach ($favorites as $favorite) {
                $favoritesProductsId[] = $favorite->product_id;
            }
            return view('products', compact('products', 'subcategories', 'categories', 'favoritesProductsId'));
        }
    }

    public function new()
    {
        $categories = Category::orderBy('name', 'ASC')->get();
        $subcategories = SubCategory::orderBy('name', 'ASC')->get();
        $products = Product::orderBy('created_at', 'DESC')->take(6)
    ->orderBy('price', 'ASC')
    ->get();
        return view('products', compact('products', 'categories', 'subcategories'));
    }

    public function cart()
    {
        return view('cart');
    }

    public function addToCart($id)
    {
        //buscamos el producto
        $product = Product::find($id);

        //comprobamos si existe el producto
        if (!$product) {
            abort(404);
        }

        //comprobamos si hay un carrito de compras en la session
        $cart = session()->get('cart');

        // Si el carrito está vacío, entonces tratamos el artículo como el primer producto y lo insertamos junto con la cantidad y el precio.
        if (!$cart) {
              $cart = [
              $id => [
                "name" => $product->title,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image
              ]
          ];
            session()->put('cart', $cart);
            return redirect()->back();
        }

        // Si el carro no está vacio comprobamos si el producto ya existe e incrementamos su cantidad.
        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
            session()->put('cart', $cart);
            return redirect('/cart');
        }

        //Si el producto no exite en el carro lo agregamos con cantidad 1
        $cart[$id] = [
        "name" => $product->title,
        "quantity" => 1,
        "price" => $product->price,
        "image" => $product->image
        ];

        session()->put('cart', $cart);
        return redirect('/cart');
    }

    public function removeCart($productID)
    {
        if ($productID) {
            $cart = session()->get('cart');
            if (isset($cart[$productID])) {
                unset($cart[$productID]);
                session()->put('cart', $cart);
            }
        }
        return redirect()->back()->with('flash_message', 'El producto ha sido removido de tu carrito');
    }
}
