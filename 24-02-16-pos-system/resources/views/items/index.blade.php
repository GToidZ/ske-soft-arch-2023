<x-app-layout>
<meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="flex flex-col w-full h-full items-center mt-2">
        <form action="/items" method="POST">
            @csrf
            <label for="description">Item Description</label>
            <input type="text" name="description" id="description" />
            <br>
            <label for="price">Item Price</label>
            <input type="number" name="price" id="price" min="0.00" step="0.01" placeholder="1.00" />
            <br>
            <button type="submit" class="bg-blue-500 text-white p-2 rounded-lg">
                + New Item
            </button>
        </form>
        @if (count($items) > 0)
            <div class="w-1/2">
                <div class="text-2xl">
                    All Items
                </div>
                <div class="mt-4 w-full">
                    <table class="w-full">
                        <thead>
                            <th>Item ID</th>
                            <th>Item Description</th>
                            <th>Price</th>
                            <th>&nbsp;</th>
                        </thead>
                        <tbody>
                            @foreach ($items as $i)
                                <tr>
                                    <td>
                                        {{ $i->id }}
                                    </td>
                                    <td>
                                        {{ $i->description }}
                                    </td>
                                    <td>
                                        {{ $i->price }}
                                    </td>
                                    <td class="flex flex-row w-full justify-end">
                                        <a href="/items/{{ $i->id }}/edit" class="bg-amber-500 p-1 rounded-lg">
                                            <span>Edit</span>
                                        </a>
                                        <button x-delete="{{ $i->id }}" class="bg-red-500 p-1 rounded-lg">
                                            <span>Delete</span>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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
<script type="text/javascript">
    $("button").on("click", function() {
        var $btn = $( this );
        if ($btn.attr('x-delete')) {
            const $id = $btn.attr('x-delete');
            $.ajax({
                type: "DELETE",
                url: "/items/" + $id,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(msg) {
                    location.reload();
                }
            })
        }
    })
</script>
