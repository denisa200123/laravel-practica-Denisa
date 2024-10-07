<?php
$productsInCart = Session::get('productsInCart');
print_r($productsInCart);
?>

<x-layout> 
    <h1>What you can buy:</h1>
    
    <table border="1" cellpadding="10">
        <tr>
            <th>Name</th>
            <th>Price</th>
            <th>Description</th>
            <th>Image</th>
            <th>Add to cart</th>
        </tr>
        @if(isset($products))
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->title }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->description }}</td>
                    <td><img src="{{ asset("images/$product->image") }}"></td>
                    <td>
                        <form action="/" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{ $product->id }}">
                            <input type="submit" value="Add to cart"></input>
                        </form>
                    </td>
                <tr>
            @endforeach
        @endif
    </table>


</x-layout>
