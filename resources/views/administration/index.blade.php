@extends('layouts.admin')

@section('pageTitle', 'Administrador')

@section('content')
<section class="optionsAdmin">


    <h3>Perfil del administrador</h3>
    <div class="card border-dark mb-3" style="max-width: 18rem;">
        <a class="card-header" href="/administration/products">Productos<a>
    </div>

    <div class="card border-dark mb-3" style="max-width: 18rem;">
        <a class="card-header" href="/administration/services">Servicios</a>
    </div>

    <div class="card border-dark mb-3" style="max-width: 18rem;">
        <a class="card-header" href="/administration/categories">Categorias</a>
    </div>

    <div class="card border-dark mb-3" style="max-width: 18rem;">
        <a class="card-header" href="/administration/subcategories">Subcategorias</a>
    </div>
</section>
@endsection
