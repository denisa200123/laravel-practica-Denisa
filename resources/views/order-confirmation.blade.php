<h1>Order Confirmation</h1>

<p>Here are the details of your order:</p>

<ul>
    @foreach ($products as $product)
        <li>{{ $product->title }} - ${{ $product->price }}</li>
    @endforeach
</ul>

{{ $customerDetails["name"] }}
{{ $customerDetails["details"] }}
{{ $customerDetails["comments"] }}
