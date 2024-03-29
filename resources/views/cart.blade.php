@extends('template')

@section('pageTitle', 'Carrito de compras')

@section('mainContent')

<table id="cart" class="table table-hover table-condensed">
    <thead>
        <tr>
            <th style="width:50%">Producto</th>
            <th style="width:10%">Precio</th>
            <th style="width:8%">Cantidad</th>
            <th style="width:22%" class="text-center">Subtotal</th>
            <th style="width:10%"></th>
        </tr>
    </thead>
    <tbody>
        <?php $total = 0 ?>

        @if(session('cart'))
        @foreach(session('cart') as $id => $details)

        <?php $total += $details['price'] * $details['quantity'] ?>

        <tr>
            <td>
                <div class="row">
                    <div class="col-sm-3 hidden-xs"><img src="/storage/productos/{{ $details['image'] }}" width="100" height="100" class="img-responsive" /></div>
                    <div class="col-sm-9">
                        <h4>{{ $details['name'] }}</h4>
                    </div>
                </div>
            </td>
            <td>${{ $details['price'] }}</td>
            <td><p class="form-control text-center">{{ $details['quantity'] }}</p></td>
            <td class="text-center">${{ $details['price'] * $details['quantity'] }}</td>
            <td class="actions" data-th="">
                <a href="/cartRemove/{{$id}}" class="btn btn-danger btn-sm" data-id="{{ $id }}">Eliminar</a>
            </td>
        </tr>
        @endforeach
        @endif

    </tbody>
    <tfoot>
        <tr>
            <td><a href="/products" class="btn btn-warning"><i class="fa fa-angle-left"></i> Continuar comprando</a></td>
            <td colspan="2" class="hidden-xs"></td>
            <td class="hidden-xs text-center"><strong>Total ${{ $total }}</strong></td>
        </tr>
    </tfoot>
</table>
@endsection
