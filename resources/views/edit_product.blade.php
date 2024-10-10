<x-layout>

    <x-slot name="title"> Edit product</x-slot>

    <x-header />

    <x-validation-messages />

    @if ($product)

        <div style="margin-left: 10px; margin-bottom: 10px;">
            <table border="1" cellpadding="10">
                <tr>
                    <x-display-product-details> </x-display-product-details>
                    <th>Edit</th>
                </tr>
                <tr>
                    <form action="{{ route('edit.product', $product->id) }}" method='post' enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <td> <input type="text" id="name" name="name" value="{{ $product->title }}"> </td>
                        <td> <input type="number" name="price" id="price" step="0.1" min="0" value="{{ $product->price }}"> </td>
                        <td> <input type="text" id="description" name="description" value="{{ $product->description }}"> </td>
                        <td> <input type="file" name="image" id="image"> </td>

                        <td><input type="submit" value="Edit" class="btn btn-warning"></td>
                    </form>
                </tr>
            </table>
        </div>

    @else
        <h3>No product to edit</h3>
    @endif

</x-layout>