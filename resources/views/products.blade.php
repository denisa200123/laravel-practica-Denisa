<x-layout>

    <x-slot name="title">{{ __('Products') }}</x-slot>

    <x-header />

    <x-validation-messages />

    @if (count($products) > 0)
        <div style="margin-left: 10px; margin-bottom: 10px; width: fit-content; height: fit-content;">
            <h2>{{ __('All the products:') }}</h2>

            <div style="display: flex; justify-content:space-between;">
                <form action="{{ route('products.index') }}" method="GET" style="width: fit-content; height: fit-content;">
                    <select name="orderBy" id="orderBy">
                        <option value="none">
                            {{ __('None') }}
                        </option>

                        <option value="title" {{ (request('orderBy') === 'title') ? 'selected' : ''}}>
                            {{ __('Name') }}
                        </option>

                        <option value="price" {{ (request('orderBy') === 'price') ? 'selected' : ''}}>
                            {{ __('Price') }}
                        </option>

                        <option value="description" {{ (request('orderBy') === 'description') ? 'selected' : ''}}>
                            {{ __('Description') }}
                        </option>
                    </select>

                    <input type="text" name="searchedProduct" id="searchedProduct" placeholder="{{ __('Search product')}}" value="{{ request('searchedProduct') }}">

                    <input type="submit" value="{{ __('Apply') }}" class="btn btn-info"></input>
                </form>

            </div>

            <table border="1" cellpadding="10" style="margin-top: 10px;">
                <tr>
                    <x-display-product-details />
                    <th>{{ __('Edit product') }}</th>
                    <th>{{ __('Remove product') }}</th>
                </tr>

                @foreach ($products as $product)
                    <tr>
                        <x-display-product :product="$product" />
                        <td>
                            <form action="{{ route('products.show', $product->id) }}" method="get">
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
