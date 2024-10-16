<br>
<div style="display: flex; justify-content:space-between; align-items:center;">
    <div style="width: fit-content; height:  fit-content; margin-left: 10px;">
        <a href="{{ route('products.index') }}" class="btn btn-dark">{{ __('See products') }}</a>
        <a href="{{ route('cart') }}" class="btn btn-dark">{{ __('Your cart') }}</a>
    </div>

    @if(session("is_admin"))
        <div style="width: fit-content; height:  fit-content;">
            <a href="{{ route('edit.page') }}" class="btn btn-dark">{{ __('Edit products') }}</a>
            <a href="{{ route('add.page') }}" class="btn btn-dark">{{ __('Add products') }}</a>
            <a href="{{ route('show.orders') }}" class="btn btn-dark">{{ __('See orders') }}</a>
        </div>

        <a href="{{ route('logout') }}" class="btn btn-dark" style="margin-right: 10px;">{{ __('Logout') }}</a>
    @else
        <a href="{{ route('login.show') }}" class="btn btn-dark" style="margin-right: 10px;">{{ __('Admin login') }}</a>
    @endif
</div>
<form id="langform" action="{{ route('set.language') }}" method="post" style="width: fit-content; height:  fit-content; margin-top:10px; margin-left: 10px;">
    @csrf
    <select name="lang" id="lang" onchange="this.form.submit()">
        <option value="en" @if (session('locale', 'en') == 'en') selected @endif> English</option>
        <option value="ro" @if (session('locale') == 'ro') selected @endif> Romanian</option>
    </select>
</form>
<br><hr>
