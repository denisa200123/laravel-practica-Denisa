<br>
<div style="display: flex; justify-content:space-between; align-items:center;">
    <div style="width: fit-content; height:  fit-content;">
        <a href="{{ route('products.index') }}" class="btn btn-dark" style="margin-left: 10px;">See products</a>
        <a href="{{ route('cart') }}" class="btn btn-dark" style="margin-left: 10px">Your cart</a>
    </div>

    @if(session("is_admin"))
        <div style="width: fit-content; height:  fit-content;">
            <a href="{{ route('edit.page') }}" class="btn btn-dark">Edit products</a>
            <a href="{{ route('add.page') }}" class="btn btn-dark">Add products</a>
        </div>
        <a href="{{ route('logout') }}" class="btn btn-dark" style="margin-right: 10px;">Logout</a>
    @else
        <a href="{{ route('login.show') }}" class="btn btn-dark" style="margin-right: 10px;">Admin login</a>
    @endif
</div>
<br><hr>
