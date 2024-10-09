<br>
<div style="display: flex; ">
    <div style="width: fit-content; height:  fit-content;">
        <a href="{{ route('products.index') }}" class="btn btn-dark" style="margin-left: 10px;">Products</a>
        <a href="{{ route('cart') }}" class="btn btn-dark" style="margin-left: 10px">Cart</a>
    </div>

    @if(session("is_admin"))
        <a href="{{ route('logout') }}" class="btn btn-dark" style="margin-left: auto; margin-right: 10px;">Logout</a>
    @else
        <a href="{{ route('login.show') }}" class="btn btn-dark" style="margin-left: auto; margin-right: 10px;">Admin login</a>
    @endif
</div>
<br><hr>
