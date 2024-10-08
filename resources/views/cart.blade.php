<x-layout>
    <x-header />

    <x-validation-messages-products-cart />

    @if ($products && count($products) > 0)

        <h2>Your products:</h2>
        <table border="1" cellpadding="10">
            <tr>
                <x-display-product-details> </x-display-product-details>
                <th>Remove</th>
            </tr>

            @foreach ($products as $product)
                <tr>
                    <x-display-product :product="$product" />
                    <td>
                        <form action="{{ route('cart.clear') }}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{ $product->id }}">
                            <input type="submit" value="Remove" class="btn btn-light"></input>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    @else
        <h2>Your cart is empty</h2>
    @endif

</x-layout>
