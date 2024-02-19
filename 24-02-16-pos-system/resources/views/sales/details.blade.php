@php
    $total_price = 0;
@endphp
<style>
    input#amount_paid::-webkit-outer-spin-button,
    input#amount_paid::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input#amount_paid {
        -moz-appearance: textfield;
    }
</style>
<x-app-layout>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="flex flex-col w-full h-full items-center mt-2">
        <span class="w-1/2 text-2xl">You're editing Sale #{{ $sale->id }}</span>
        <span class="w-1/2 text-2xl">Status: {{ $sale->paid ? 'PAID' : 'UNPAID' }}</span>
        <div class="flex flex-row w-3/4 justify-between mt-10">
            @if (!$sale->member_id)
            <form action="{{ route('sales.update', ['id' => $sale->id]) }}" method="POST">
                @method('PUT')
                @csrf
                <input type="hidden" id="perform" name="perform" value="set_member"></input>
                <label for="item_id">Member ID</label>
                <input type="text" name="member_id" id="member_id" />
                <br>
                <button type="submit" class="bg-blue-500 text-white p-2 rounded-lg">
                    Add Member
                </button>
            </form>
            @else
            <span class="text-2xl">Sale for Member #{{ $sale->member_id }}</span>
            @endif
            <form action="{{ route('sales.update', ['id' => $sale->id]) }}" method="POST">
                @method('PUT')
                @csrf
                <input type="hidden" id="perform" name="perform" value="add_item"></input>
                <label for="item_id">Item ID</label>
                <input type="text" name="item_id" id="item_id" />
                <br>
                <label for="quantity">Quantity</label>
                <input type="number" name="quantity" id="quantity" min="1" step="1" value="1" />
                <br>
                <button type="submit" class="bg-blue-500 text-white p-2 rounded-lg">
                    + New Item
                </button>
            </form>
        </div>
        @if (count($sale->items) > 0)
            <!-- TODO: Create a table to host each LineItem -->
            <!-- Item Desc | Quantity | Price | Change, Remove -->
            <div class="mt-4 w-3/4">
                <table class="w-full">
                    <thead>
                        <th>Item</th>
                        <th style="width: 30%">Qty.</th>
                        <th style="width: 10%">Price</th>
                        <th style="width: 10%">&nbsp;</th>
                    </thead>
                    <tbody>
                        @foreach ($sale->items as $item)
                            <tr>
                                <td>
                                    {{ $item->getItem()->description }}
                                </td>
                                <td>
                                    <form action="{{ route('sales.update', ['id' => $sale->id]) }}" method="POST">
                                        @method('PUT')
                                        @csrf
                                        <input type="hidden" id="perform" name="perform" value="update_item"></input>
                                        <input type="hidden" id="line_id" name="line_id"
                                            value="{{ $item->id }}"></input>
                                        <input type="number" name="quantity" id="quantity" min="1"
                                            step="1" value="{{ $item->quantity }}" />
                                        <button type="submit" class="bg-amber-500 p-2 rounded-lg">
                                            Update
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    {{ $item->getItem()->price * $item->quantity }}
                                </td>
                                <td>
                                    <form action="{{ route('sales.update', ['id' => $sale->id]) }}" method="POST">
                                        @method('PUT')
                                        @csrf
                                        <input type="hidden" id="perform" name="perform" value="remove_item"></input>
                                        <input type="hidden" id="line_id" name="line_id"
                                            value="{{ $item->id }}"></input>
                                        <button type="submit" class="bg-red-500 text-white p-2 rounded-lg">
                                            Remove
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @php
                                $total_price += $item->getItem()->price * $item->quantity;
                            @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="flex flex-row justify-end mt-10 w-3/4">
                <form class="flex flex-col items-end gap-y-4" action="{{ route('sales.pay', ['id' => $sale->id]) }}"
                    method="POST">
                    @csrf
                    <div class="flex flex-row items-baseline gap-x-2">Grand Total:
                        @if (!$sale->member_id)
                        <span class="text-blue-500 text-2xl font-bold">THB {{ $total_price }}</span>
                        @else
                        <span class="text-blue-500 text-2xl font-bold">THB {{ $total_price * 0.9 }}</span>
                        <span class="text-blue-500">(-{{ $total_price * 0.1 }})</span>
                        @endif
                    </div>
                    @if (!$sale->paid)
                    <label for="amount_paid">Amount to Pay:</label>
                    <input type="number" id="amount_paid" name="amount_paid" value="0" min="0" />
                    <button type="submit" class="bg-blue-500 text-white p-2 rounded-lg px-3">Pay</button>
                    @endif
                </form>
            </div>
            
        @else
            <div class="">
                <div class="text-2xl text-red-500">
                    No Items yet!
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
