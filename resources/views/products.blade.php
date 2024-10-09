<x-layout>
    <x-slot name="title"> Products </x-slot>

    <x-header />
    
    <x-validation-messages-products-cart />

    @if (session('OrderSuccess'))
        <p class="alert alert-success"> {{ session('OrderSuccess') }} </p>
    @endif

    @if (session('LoginSuccess'))
        <p class="alert alert-success"> {{ session('LoginSuccess') }} </p>
    @endif

    @if ($products && count($products) > 0)
        <div style="margin-left: 10px; margin-bottom: 10px;">
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
        </div>

    @else
        <h2 style="margin-left: 10px;">You bought everything.</h2>
    @endif
    
</x-layout>
