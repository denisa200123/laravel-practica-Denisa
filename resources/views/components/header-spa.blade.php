<header>
    <br>
    <div style="display: flex; justify-content:space-between; align-items:center;">
        <div style="width: fit-content; height: fit-content; margin-left: 10px;">
            <a href="#" class="btn btn-dark">{{ __('Store') }}</a>
            <a href="#cart" class="btn btn-dark">{{ __('Your cart') }}</a>
        </div>

        @if (session("is_admin"))
            <div style="width: fit-content; height: fit-content;">
                <div style="width: fit-content; height: fit-content;">
                    <a href="#products" class="btn btn-dark">{{ __('Products') }}</a>
                    <a href="#show" class="btn btn-dark" style="margin-left: 10px;">{{ __('Create product') }}</a>
                    <a href="#orders" class="btn btn-dark" style="margin-left: 10px;">{{ __('See orders') }}</a>
                </div>
            </div>

            <div style="width: fit-content; height: fit-content; margin-right: 10px;">
                <a href="#logout" class="btn btn-dark">{{ __('Logout') }}</a>
            </div>
        @else
            <div style="width: fit-content; height: fit-content; margin-right: 10px;">
                <a href="#login" class="btn btn-dark">{{ __('Admin login') }}</a>
            </div>
        @endif
    </div>

    <form id="languageForm" style="width: fit-content; height: fit-content; margin-top:10px; margin-left: 10px;">
        <select name="locale" id="locale">
            <option value="en" @if (session('locale', 'en') === 'en') selected @endif>{{ __('English') }}</option>
            <option value="ro" @if (session('locale') === 'ro') selected @endif>{{ __('Romanian') }}</option>
            <option value="es" @if (session('locale') === 'es') selected @endif>{{ __('Spanish') }}</option>
        </select>
    </form>

    <br>
    <hr>
</header>
