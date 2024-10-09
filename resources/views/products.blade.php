<x-layout>
    <x-slot name="title"> Products </x-slot>

    <x-header />

    <x-validation-messages-products-cart />
    @if (session('OrderSuccess'))
        <p class="alert alert-success"> {{ session('OrderSuccess') }} </p>
    @endif
    @if ($products && count($products) > 0)

        <h2>What you can buy:</h2>
        <table border="1" cellpadding="10">
            <tr>
                <x-display-product-details> </x-display-product-details>
                <th>Add to cart</th>
            </tr>

            @foreach ($products as $product)
                <tr>
                    <x-display-product :product="$product" />
                    <td>
                        <form action="{{ route('products.store') }}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{ $product->id }}">
                            <input type="submit" value="Add to cart" class="btn btn-light"></input>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>

    @else
        <h2>You bought everything.</h2>
    @endif
    
</x-layout>
