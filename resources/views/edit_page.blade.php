<x-layout>

    <x-slot name="title"> Edit page</x-slot>

    <x-header />

    @if (session('DeleteSuccess'))
        <p class="alert alert-success"> {{ session('DeleteSuccess') }} </p>
    @endif

    @if (session('DeleteFail'))
        <p class="alert alert-danger"> {{ session('DeleteFail') }} </p>
    @endif

    @if (session('EditSuccess'))
        <p class="alert alert-success"> {{ session('EditSuccess') }} </p>
    @endif

    @if (session('EditProductFail'))
        <p class="alert alert-danger"> {{ session('EditProductFail') }} </p>
    @endif

    @if ($products && count($products) > 0)
        <div style="margin-left: 10px; margin-bottom: 10px;">
            <h2>All the products:</h2>
            <table border="1" cellpadding="10">
                <tr>
                    <x-display-product-details> </x-display-product-details>
                    <th>Edit product</th>
                    <th>Remove product</th>
                </tr>

                @foreach ($products as $product)
                    <tr>
                        <x-display-product :product="$product" />
                        <td>
                            <form action="{{ route('edit.product.page', $product->id) }}" method="post">
                                @csrf
                                <input type="submit" value="Edit product" class="btn btn-warning"></input>
                            </form>
                        </td>
                        <td>
                            <form action="{{ route('delete.product', $product->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <input type="submit" value="Delete" class="btn btn-danger"></input>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>

    @else
        <h2 style="margin-left: 10px;">No products to edit.</h2>
    @endif

</x-layout>