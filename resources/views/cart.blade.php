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

        <h2>Checkout</h2>
        <form action="{{ route('checkout.process') }}" method="post">
            @csrf
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required><br><br>

            <label for="details">Order details:</label>
            <input type="details" id="details" name="details" required><br><br>

            <label for="comments">Comments:</label>
            <textarea id="comments" name="comments"></textarea><br><br>

            <button type="submit" class="btn btn-primary">Place Order</button>
        </form>

    @else
        <h2>Your cart is empty</h2>
    @endif

</x-layout>
