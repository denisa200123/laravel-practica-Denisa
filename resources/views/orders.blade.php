<x-layout>
    <x-slot name="title"> {{ __('Orders') }} </x-slot>

    <x-header />
    
    <x-validation-messages />

    @if ($orders && count($orders) > 0)
        <div style="margin-left: 10px; margin-bottom: 10px;">
            <h2>{{ __('Orders:') }}</h2>
            <table border="1" cellpadding="10">
                <tr>
                    <x-display-order-details> </x-display-order-details>
                    <th>{{ __('See details') }}</th>
                </tr>

                @foreach ($orders as $order)
                    <tr>
                        <x-display-order :order="$order" />
                        <td>
                            <form action="{{ route('orders.index') }}" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{ $order->id }}">
                                <input type="submit" value="{{ __('See details') }}" class="btn btn-light"></input>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>

    @else
        <h2 style="margin-left: 10px;">{{ __('No orders to show.') }}</h2>
    @endif
    
</x-layout>
