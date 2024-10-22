<x-layout>

    <x-slot name="title"> {{ __('Products') }}</x-slot>

    <x-header />

    <x-validation-messages />

    @if ($products && count($products) > 0)
        <div style="margin-left: 10px; margin-bottom: 10px;">
            <h2>{{ __('All the products:') }}</h2>
            
            <table border="1" cellpadding="10">
                <tr>
                    <x-display-product-details> </x-display-product-details>
                    <th>{{ __('Edit product') }}</th>
                    <th>{{ __('Remove product') }}</th>
                </tr>
                
                @foreach ($products as $product)
                    <tr>
                        <x-display-product :product="$product" />
                        <td>
                            <form action="{{ route('products.edit', $product->id) }}" method="get">
                                @csrf
                                <input type="submit" value="{{ __('Edit') }}" class="btn btn-warning"></input>
                            </form>
                        </td>
                        <td>
                            <form action="{{ route('products.destroy', $product->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <input type="submit" value="{{ __('Delete') }}" class="btn btn-danger"></input>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>

        <div style="margin: 20px 0 0 20px">
            {{ $products->links('pagination::bootstrap-4') }}
        </div>

    @else
        <h2 style="margin-left: 10px;">{{ __('No products to edit.') }}</h2>
    @endif

</x-layout>
