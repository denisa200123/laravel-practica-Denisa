<x-layout>
    @if (session('success'))
        {{ session('success') }}
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
                            <input type="submit" value="Add to cart"></input>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>

    @else
        <h2>You bought everything.</h2>
    @endif

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    @endif

</x-layout>
