<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\SubCategory;
use App\Service;

class AdministrationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('administration.index');
    }

    //productos ADMIN
    public function listProducts()
    {
      $products = Product::all();
      return view('administration.products.list', compact("products"));
    }

    public function newProduct()
    {
      $subcategories = SubCategory::orderBy('name')->get();
      $categories = Category::orderBy('name')->get();
      return view('administration.products.new',compact('categories', 'subcategories'));
    }

    public function store(Request $request){
      // Validamos
		$request->validate([
			'title' => 'required',
			'description' => 'required',
			'category_id' => 'required',
      'offer' => 'required',
      'price' => 'required | numeric',
			'image' => 'required | image',
			'image' => 'required | mimes:jpg,png,jpeg',
      'subcategory_id' => 'required'
		], [
			'title.required' => 'El nombre del producto es obligatorio',
      'description.required' => 'El producto debe tener una descripcion',
			'category_id.required' => 'Selecciona una categoria',
      'subcategory_id.required' => 'Selecciona la subcategoria del producto',
      'image.mimes' => 'El producto debe ser un formato jpg,png o jpeg',
			'price.numeric' => 'El precio solo admite números',
      'price.required' => 'El campo precio es obligatorio',
      'image.required' => 'El producto debe tener una imagen',
      'offer.required' => '¿Tiene el producto una oferta?'
		]);

		$productSaved = Product::create($request->all());
		$imagen = $request["image"];
		$imagenFinal = uniqid("img_") . "." . $imagen->extension();
    $request->file('image')->move(public_path('/img/Productos'),$imagenFinal); //(arreglar)//
		// Le asigno la imagen al producto que guardamos
		$productSaved->image = $imagenFinal;
		$productSaved->save();

		// Redireccionamos
		return redirect('/administration/products');
    }

    public function editProduct ($id)
	  {
      $productToEdit = Product::find($id);
      $subcategories = SubCategory::orderBy('name')->get();
      $categories = Category::orderBy('name')->get();
		  return view('administration.products.edit', compact('productToEdit', 'categories', 'subcategories'));
	 }

   public function updateProduct ($id, Request $request)
	 {
		$productToUpdate = Product::find($id);
		$productToUpdate->title = $request['title'];
		$productToUpdate->description = $request['description'];
		$productToUpdate->category_id = $request['category_id'];
		$productToUpdate->subcategory_id = $request['subcategory_id'];
		$productToUpdate->offer = $request['offer'];
		$productToUpdate->price = $request['price'];
		$productToUpdate->save();
		return redirect('/administration/products');
	}

  public function deleteProduct ($id){
    $productToDelete = Product::find($id);
    $productToDelete->delete();

    return redirect('/administration/products');
  }

  //servicios ADMIN
  public function listServices()
  {
    $services = Service::all();
    return view('administration.services.list', compact("services"));
  }

  public function newService()
  {
    $categories = Category::orderBy('name')->get();
    return view('administration.services.new',compact('categories'));
  }

  public function storeService(Request $request){
    // Validamos
  $request->validate([
    'name' => 'required',
    'description' => 'required',
    'category_id' => 'required',
    'image' => 'required | image',
    'image' => 'required | mimes:jpg,png,jpeg',
  ], [
    'name.required' => 'El nombre del servicio es obligatorio',
    'description.required' => 'El servicio debe tener una breve descripcion',
    'category_id.required' => 'Seleccione la categoria a la que pertenece el servicio nuevo',
    'image.mimes' => 'La imagen debe ser un formato jpg, png o jpeg',
    'image.required' => 'El servicio debe tener una imagen principal',
  ]);

  $serviceSaved = Service::create($request->all());
  $imagen = $request["image"];
  $imagenFinal = uniqid("img_") . "." . $imagen->extension();
  $request->file('image')->move(public_path('/img/Servicios'),$imagenFinal); //(arreglar)//
  // Le asigno la imagen al servicio que guardamos
  $serviceSaved->image = $imagenFinal;
  $serviceSaved->save();

  // Redireccionamos
  return redirect('/administration/services');
  }

  public function editService ($id)
  {
    $serviceToEdit = Service::find($id);
    $categories = Category::orderBy('name')->get();
    return view('administration.services.edit', compact('serviceToEdit', 'categories'));
 }

 public function updateService ($id, Request $request)
 {
  $serviceToUpdate = Service::find($id);
  $serviceToUpdate->name = $request['name'];
  $serviceToUpdate->description = $request['description'];
  $serviceToUpdate->category_id = $request['category_id'];
  $serviceToUpdate->save();
  return redirect('/administration/services');
}

public function deleteService ($id){
  $serviceToDelete = Service::find($id);
  $serviceToDelete->delete();

  return redirect('/administration/services');
}



}
