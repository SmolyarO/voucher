@extends('layout')
@section('title', 'Products')

@section('content')
    <div class="content">
        <div class="title m-b-md">
            Products
        </div>

        @if(isset($products))
            <table class="table">
                <tr>
                    <td>Product</td>
                    <td>Price</td>
                    <td></td>
                </tr>
                @foreach($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>$ {{ $product->price }}</td>
                        <td>
                            @include('products._form', [
                            'action' => route('buyProduct', $product->id),
                            'text' => 'Buy'
                            ])
                        </td>
                    </tr>
                @endforeach
            </table>
        @endif

    </div>
@endsection
